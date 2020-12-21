<?php

namespace App\Http\Controllers;

use App\carts;
use App\Category;
use App\Generalsetting;
use App\handyman_quotes;
use App\handyman_terminals;
use App\handyman_unavailability;
use App\items;
use App\predefined_answers;
use App\question_services;
use App\quotation_invoices;
use App\quotation_questions;
use App\quotes;
use App\requests_q_a;
use App\sub_services;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use Auth;
use App\bookings;
use App\handyman_services;
use App\users;
use App\service_types;
use App\invoices;
use App\handyman_temporary;
use File;
use PDF;
use Illuminate\Database\Eloquent\SoftDeletes;


class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function QuotationQuestions()
    {
        $data = quotation_questions::with('answers')->with(['services' => function($query){
        $query->leftjoin('categories','categories.id','=','question_services.service_id');
        }])->get();


        return view('admin.user.questions',compact('data','services'));
    }

    public function CreateQuestion()
    {
        $services = Category::where('main_service',1)->get();

        return view('admin.user.create_question',compact('services'));
    }

    public function EditQuestion($id)
    {
        $services = Category::where('main_service',1)->get();

        $data = quotation_questions::where('id',$id)->with('answers')->with('services')->first();

        return view('admin.user.create_question',compact('services','data'));
    }

    public function SubmitQuestion(Request $request)
    {

        $predefined = $request->predefined;

        if($predefined == 'on')
        {
            $predefined = 1;
        }
        else
        {
            $predefined = 0;
        }

        if(!$request->question_id)
        {
            $question = new quotation_questions;
            $question->title = $request->title;
            $question->predefined = $predefined;
            $question->save();

            foreach ($request->services as $i => $temp)
            {
                $post = new question_services;
                $post->question_id = $question->id;
                $post->service_id = $temp;
                $post->save();
            }

            if($predefined)
            {
                foreach ($request->predefined_answer as $key)
                {
                    $answer = new predefined_answers;
                    $answer->question_id = $question->id;
                    $answer->title = $key;
                    $answer->save();
                }
            }

            Session::flash('success', 'Flexible Question Created Successfully!');
        }
        else
        {
            $question = quotation_questions::where('id',$request->question_id)->update(['title' => $request->title, 'predefined' => $predefined]);

            question_services::where('question_id',$request->question_id)->delete();

                foreach ($request->services as $service)
                {
                    $services = new question_services;
                    $services->question_id = $request->question_id;
                    $services->service_id = $service;
                    $services->save();
                }

            predefined_answers::where('question_id',$request->question_id)->delete();

            if($predefined)
            {

                foreach ($request->predefined_answer as $key)
                {
                    $answer = new predefined_answers;
                    $answer->question_id = $request->question_id;
                    $answer->title = $key;
                    $answer->save();
                }
            }

            Session::flash('success', 'Flexible Question Updated Successfully!');
        }

        return redirect()->back();

    }

    public function DeleteQuestion($id)
    {

        $question = quotation_questions::where('id',$id)->delete();
        $sub = predefined_answers::where('question_id',$id)->delete();
        $services = question_services::where('question_id',$id)->delete();

        Session::flash('success', 'Question deleted successfully.');
        return redirect()->back();
    }

    public function index()
    {
        $users = User::where('role_id','=',2)->orderBy('created_at','desc')->get();

        foreach ($users as $key) {

             $categories[] = handyman_services::leftjoin('categories','categories.id','=','handyman_services.service_id')->where('handyman_services.handyman_id',$key->id)->select('categories.cat_name')->get();

        }

        return view('admin.user.index',compact('users','categories'));
    }


    public function QuotationRequests()
    {
        $requests = quotes::leftjoin('categories','categories.id','=','quotes.quote_service')->orderBy('quotes.created_at','desc')->select('quotes.*','categories.cat_name')->withCount('quotations')->get();


        return view('admin.user.quote_requests',compact('requests'));
    }

    public function HandymanQuotations($id = '')
    {
        if($id)
        {
            $invoices = quotation_invoices::leftjoin('quotes','quotes.id','=','quotation_invoices.quote_id')->leftjoin('users','users.id','=','quotation_invoices.handyman_id')->where('quotation_invoices.quote_id',$id)->orderBy('quotation_invoices.created_at','desc')->select('quotes.*','quotation_invoices.id as invoice_id','quotation_invoices.invoice','quotation_invoices.approved','quotation_invoices.accepted','quotation_invoices.ask_customization','quotation_invoices.quotation_invoice_number','quotation_invoices.tax','quotation_invoices.subtotal','quotation_invoices.grand_total','quotation_invoices.created_at as invoice_date','users.name','users.family_name')->get();
        }
        else
        {
            $invoices = quotation_invoices::leftjoin('quotes','quotes.id','=','quotation_invoices.quote_id')->leftjoin('users','users.id','=','quotation_invoices.handyman_id')->orderBy('quotation_invoices.created_at','desc')->select('quotes.*','quotation_invoices.id as invoice_id','quotation_invoices.invoice','quotation_invoices.approved','quotation_invoices.accepted','quotation_invoices.ask_customization','quotation_invoices.quotation_invoice_number','quotation_invoices.tax','quotation_invoices.subtotal','quotation_invoices.grand_total','quotation_invoices.created_at as invoice_date','users.name','users.family_name')->get();
        }

        return view('admin.user.quote_invoices',compact('invoices'));
    }

    public function HandymanQuotationsInvoices($id = '')
    {
        if($id)
        {
            $invoices = quotation_invoices::leftjoin('quotes','quotes.id','=','quotation_invoices.quote_id')->leftjoin('users','users.id','=','quotation_invoices.handyman_id')->where('quotes.status','=',3)->where('quotation_invoices.quote_id',$id)->where('quotes.status','<',3)->where('quotation_invoices.invoice',1)->orderBy('quotation_invoices.created_at','desc')->select('quotes.*','quotation_invoices.id as invoice_id','quotation_invoices.approved','quotation_invoices.accepted','quotation_invoices.ask_customization','quotation_invoices.quotation_invoice_number','quotation_invoices.tax','quotation_invoices.subtotal','quotation_invoices.grand_total','quotation_invoices.created_at as invoice_date','users.name','users.family_name')->get();
        }
        else
        {
            $invoices = quotation_invoices::leftjoin('quotes','quotes.id','=','quotation_invoices.quote_id')->leftjoin('users','users.id','=','quotation_invoices.handyman_id')->where('quotes.status','=',3)->where('quotation_invoices.invoice',1)->orderBy('quotation_invoices.created_at','desc')->select('quotes.*','quotation_invoices.id as invoice_id','quotation_invoices.approved','quotation_invoices.accepted','quotation_invoices.ask_customization','quotation_invoices.quotation_invoice_number','quotation_invoices.tax','quotation_invoices.subtotal','quotation_invoices.grand_total','quotation_invoices.created_at as invoice_date','users.name','users.family_name')->get();
        }

        return view('admin.user.quote_invoices',compact('invoices'));
    }

    public function QuoteRequest($id)
    {
        $request = quotes::leftjoin('categories','categories.id','=','quotes.quote_service')->where('quotes.id',$id)->select('quotes.*','categories.cat_name')->withCount('quotations')->first();

        $q_a = requests_q_a::where('request_id',$id)->get();

        $services = Category::where('main_service',1)->get();

        return view('admin.user.quote_request',compact('request','services','q_a'));
    }

    public function DownloadQuoteRequest($id)
    {
        $quote = quotes::leftjoin('categories','categories.id','=','quotes.quote_service')->where('quotes.id',$id)->select('quotes.*','categories.cat_name')->first();

        $q_a = requests_q_a::where('request_id',$id)->get();

        $date = strtotime($quote->created_at);

        $quote_number = date("Y", $date) . "-" . sprintf('%04u', $quote->id);

        $filename = $quote_number.'.pdf';

        $file = public_path().'/assets/quotesPDF/'.$filename;

        if (!file_exists($file)){

            ini_set('max_execution_time', 180);

            $pdf = PDF::loadView('admin.user.pdf_quote',compact('quote','q_a'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140]);

            $pdf->save(public_path().'/assets/quotesPDF/'.$filename);
        }

        return response()->download(public_path("assets/quotesPDF/{$filename}"));
    }

    public function ViewQuotation($id)
    {
        $settings = Generalsetting::findOrFail(1);

        $vat_percentage = $settings->vat;

        $quotation = quotation_invoices::leftjoin('quotation_invoices_data','quotation_invoices_data.quotation_id','=','quotation_invoices.id')->leftjoin('quotes','quotes.id','=','quotation_invoices.quote_id')->where('quotation_invoices.id',$id)->select('quotation_invoices.*','quotes.id as quote_id','quotes.created_at as quote_date','quotation_invoices_data.id as data_id','quotation_invoices_data.s_i_id','quotation_invoices_data.item','quotation_invoices_data.rate','quotation_invoices_data.qty','quotation_invoices_data.description as data_description','quotation_invoices_data.estimated_date','quotation_invoices_data.amount')->get();


        if(count($quotation) != 0)
        {
            $services = Category::leftjoin('handyman_services','handyman_services.service_id','=','categories.id')->where('handyman_services.handyman_id',$quotation[0]->handyman_id)->select('categories.*','handyman_services.rate','handyman_services.description')->get();

            $items = items::where('user_id',$quotation[0]->handyman_id)->get();

            return view('admin.user.quotation',compact('quotation','services','vat_percentage','items'));
        }
        else
        {
            return redirect('logstof/dashboard');
        }
    }

    public function DownloadQuoteInvoice($id)
    {
        $invoice = quotation_invoices::where('id',$id)->first();

        $quotation_invoice_number = $invoice->quotation_invoice_number;

        $filename = $quotation_invoice_number.'.pdf';

        return response()->download(public_path("assets/quotationsPDF/{$filename}"));
    }

    public function SendQuoteRequest($id)
    {

        $request = quotes::leftjoin('categories','categories.id','=','quotes.quote_service')->where('quotes.id',$id)->select('quotes.*','categories.cat_name')->first();

        $search = $request->quote_zipcode;

        $url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBNlftIg-4OOM7dicTvWaJm46DgD-Wz61Q&address=".urlencode($search).",+Netherlands&sensor=false";

        $result_string = file_get_contents($url);
        $result = json_decode($result_string, true);

        $history = handyman_quotes::leftjoin('users','users.id','=','handyman_quotes.handyman_id')->where('handyman_quotes.quote_id',$id)->select('users.*','handyman_quotes.created_at as quote_date')->get();

        if(($result['status']) != 'ZERO_RESULTS' )
        {
            $user_latitude = $result['results'][0]['geometry']['location']['lat'];
            $user_longitude = $result['results'][0]['geometry']['location']['lng'];

            $array[] = "";
            $array1[] = "";
            $i = 0;

            $handymen = handyman_services::leftjoin('users','users.id','=','handyman_services.handyman_id')->leftjoin('handyman_terminals','handyman_terminals.handyman_id','=','users.id')->where('users.active',1)->where('handyman_services.service_id','=', $request->quote_service)->select('users.*','handyman_terminals.zipcode','handyman_terminals.longitude','handyman_terminals.latitude')->get();

            foreach ($handymen as $key) {

                $lat = $key->latitude;
                $lng = $key->longitude;

                $theta = $lng - $user_longitude;
                $dist = sin(deg2rad($lat)) * sin(deg2rad($user_latitude)) +  cos(deg2rad($lat)) * cos(deg2rad($user_latitude)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                $distance = $miles * 1.609344;

                $array[$i] = array('handyman_id'=>$key->id);
                $array1[$i] = array('handyman_distance'=>$distance);
                $i = $i + 1;

            }

            $other_handymen = handyman_terminals::leftjoin('users','users.id','=','handyman_terminals.handyman_id')->whereNotIn('users.id',$array)->where('users.active',1)->select('users.*','handyman_terminals.zipcode','handyman_terminals.longitude','handyman_terminals.latitude')->get();

            $array2[] = "";
            $x = 0;

            foreach ($other_handymen as $key) {

                $lat = $key->latitude;
                $lng = $key->longitude;

                $theta = $lng - $user_longitude;
                $dist = sin(deg2rad($lat)) * sin(deg2rad($user_latitude)) +  cos(deg2rad($lat)) * cos(deg2rad($user_latitude)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                $distance = $miles * 1.609344;

                $array2[$x] = array('handyman_distance'=>$distance);
                $x = $x + 1;

            }

        }

        else
        {
            Session::flash('unsuccess', 'Invalid Postal code given in quote request!');
            return redirect()->back();
        }

        return view('admin.user.send_quote',compact('request','handymen','array1','array2','history','other_handymen'));
    }


    public function ApproveHandymanQuotations(Request $request)
    {
        $handyman = $request->action;

        foreach ($handyman as $key)
        {
            $quotation = quotation_invoices::where('id',$key)->first();
            $quotation->approved = 1;
            $quotation->save();

            $user = quotes::leftjoin('quotation_invoices','quotation_invoices.quote_id','=','quotes.id')->leftjoin('users','users.id','=','quotes.user_id')->where('quotation_invoices.id',$key)->select('users.*','quotes.created_at')->first();

            $client_name = $user->name . ' ' . $user->family_name;
            $client_email = $user->email;

            $date = strtotime($user->created_at);

            $requested_quote_number = date("Y", $date) . "-" . sprintf('%04u', $user->quote_id);

            $quotation_invoice_number = $quotation->quotation_invoice_number;

            $filename = $quotation_invoice_number.'.pdf';

            $file = public_path().'/assets/quotationsPDF/'.$filename;

            $user = users::where('id',$quotation->handyman_id)->first();
            $user_name = $user->name. ' ' .$user->family_name;
            $email = $user->email;

            $link = url('/').'/handyman/dashboard';

            \Mail::send('admin.user.quotation_approved_mail',
                array(
                    'username' => $user_name,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'requested_quote_number' => $requested_quote_number,
                    'link' => $link,
                ), function ($message) use($email){
                    $message->from('info@topstoffeerders.nl');
                    $message->to($email)->subject('Your Quotation has been Approved!');

                });

            $client_link = url('/').'/handyman/client-dashboard';

            \Mail::send('admin.user.quotation_client_mail',
                array(
                    'handyman' => $user_name,
                    'client' => $client_name,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'requested_quote_number' => $requested_quote_number,
                    'client_link' => $client_link,
                ), function ($message) use($file,$client_email,$filename) {
                    $message->from('info@topstoffeerders.nl');
                    $message->to($client_email)->subject('New Quotation Received!');

                    $message->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);

                });

        }

        Session::flash('success', 'Quotation approved successfully!');
        return redirect()->back();


    }

    public function SendQuoteRequestHandymen(Request $request)
    {
        $handyman = $request->action;

        $quote = quotes::leftjoin('categories','categories.id','=','quotes.quote_service')->where('quotes.id',$request->quote_id)->select('quotes.*','categories.cat_name')->first();

        $q_a = requests_q_a::where('request_id',$request->quote_id)->get();

        $date = strtotime($quote->created_at);

        $quote_number = date("Y", $date) . "-" . sprintf('%04u', $quote->id);

        $filename = $quote_number.'.pdf';

        $file = public_path().'/assets/quotesPDF/'.$filename;

        if (!file_exists($file)){

            ini_set('max_execution_time', 180);

            $pdf = PDF::loadView('admin.user.pdf_quote',compact('quote','q_a'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140]);

            $pdf->save(public_path().'/assets/quotesPDF/'.$filename);
        }


        foreach ($handyman as $key)
        {
            $user = users::where('id',$key)->first();
            $email = $user->email;

            $user_name = $user->name. ' ' .$user->family_name;

            $save = handyman_quotes::where('handyman_id',$key)->where('quote_id',$request->quote_id)->first();

            if(!$save)
            {
                $save = new handyman_quotes;
                $save->handyman_id = $key;
                $save->quote_id = $request->quote_id;
                $save->save();
            }
            else
            {
                handyman_quotes::where('handyman_id',$key)->where('quote_id',$request->quote_id)->update(['updated_at' => date('Y-m-d H:i:s', time())]);
            }

            $link = url('/').'/handyman/dashboard';

            \Mail::send('admin.user.quote_request_mail',
                array(
                    'username' => $user_name,
                    'link' => $link,
                ), function ($message) use($file,$email,$filename){
                $message->from('info@topstoffeerders.nl');
                $message->to($email)->subject('Quotation Request!');

                        $message->attach($file, [
                            'as' => $filename,
                            'mime' => 'application/pdf',
                        ]);

            });

        }

        Session::flash('success', 'Quotation request sent successfully!');
        return redirect()->back();


    }

    public function Clients()
    {
        $users = User::where('role_id','=',3)->orderBy('created_at','desc')->get();

        foreach ($users as $key) {

             $categories[] = handyman_services::leftjoin('categories','categories.id','=','handyman_services.service_id')->where('handyman_services.handyman_id',$key->id)->select('categories.cat_name')->get();

        }

        return view('admin.user.clients',compact('users','categories'));
    }

    public function UserBookings()
    {
        $users_bookings = invoices::leftjoin('users','users.id','=','invoices.user_id')->Select('users.name','users.family_name','users.email','invoices.booking_date','invoices.total','invoices.status','invoices.id','invoices.handyman_id','invoices.is_booked','invoices.is_completed','invoices.pay_req','invoices.is_partial','invoices.is_cancelled','invoices.cancel_req','invoices.reason','invoices.reply','invoices.is_paid','invoices.created_at as inv_date','invoices.invoice_number','invoices.user_id')->orderBy('id', 'desc')->get();

        $handymans_booked = invoices::leftjoin('users','users.id','=','invoices.handyman_id')->orderBy('invoices.id', 'desc')->get();

        $data[] = array('users'=>$users_bookings,'handymans'=>$handymans_booked);

        return view('admin.user.bookings',compact('data'));
    }

    public function UserRequests()
    {
        $users_requests = handyman_temporary::leftjoin('users','users.id','=','handyman_temporary.handyman_id')->Select('users.name','users.family_name','users.email','handyman_temporary.created_at as Date','handyman_temporary.updated_at as UpdateDate','users.photo','handyman_temporary.handyman_id')->orderBy('handyman_temporary.id', 'desc')->get();

        return view('admin.user.requets',compact('users_requests'));
    }

    public function UserRequest($id)
    {
        $user = handyman_temporary::where('handyman_id','=',$id)->first();
        return view('admin.user.request',compact('user'));
    }

     public function RequestProfileUpdate(Request $request)
    {
        $input = $request->all();

        $user_id = $input['handyman_id'];

        $user = users::where('id',$user_id)->first();

        if($input['photo'])
        {
            $old_path =  public_path().'/assets/temporary_images/'. $input['photo'];

            $new_path =  public_path().'/assets/images/'. $input['photo'];

            $move = File::move($old_path, $new_path);

            if($user->photo != null)
                {
                    unlink(public_path().'/assets/images/'.$user->photo);
                }
        }
        else
        {

            $input['photo'] = $user->photo;

        }


        $update = users::where('id',$user_id)->update(['name' => $input['name'], 'family_name' => $input['family_name'], 'photo' => $input['photo'], 'description' => $input['description'], 'language' => $input['language'], 'education' => $input['education'], 'profession' => $input['profession'], 'city' => $input['city'], 'address' => $input['address'], 'phone' => $input['phone'],  'web' => $input['web'], 'special' => $input['special'], 'registration_number' => $input['registration_number'], 'company_name' => $input['company_name'], 'tax_number' => $input['tax_number'], 'bank_account' => $input['bank_account'], 'postcode' => $input['postcode'] ]);

        $delete = handyman_temporary::where('handyman_id',$user_id)->delete();

        $user = User::findOrFail($user_id);

        $email = $user->email;

        $user_name = $user->name. ' ' .$user->family_name;

        $handyman_dash = url('/').'/handyman/dashboard';


        $headers =  'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From: Topstoffeerders <info@topstoffeerders.nl>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Profile Information Updated Successfully!";
        $msg = "Dear Mr/Mrs ". $user_name .",<br><br>Your profile information update request has been approved. For further details visit your handyman panel through <a href='".$handyman_dash."'>here.</a><br><br>Kind regards,<br><br>Klantenservice Topstoffeerders";
        mail($email,$subject,$msg,$headers);


        $headers =  'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From: Topstoffeerders <info@topstoffeerders.nl>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Profiel informatie is geupdate";
        $msg = "Beste". $user_name .",<br><br>je wijziging in je profiel is goeggekeurd. Klik op account om de status van je klus te bekijken <a href='".$handyman_dash."'>account.</a><br><br>Met vriendelijke groet,<br><br>Klantenservice Topstoffeerders";
        mail($email,$subject,$msg,$headers);

        Session::flash('success', 'Profile Updated Successfully');

        return redirect()->route('admin-user-requests');
    }


  public function status($id1,$id2)
    {

        $user = User::findOrFail($id1);
        $user->active = $id2;
        $user->featured = $id2;
        $user->update();
        Session::flash('success', 'Status updated Successfully');

        return redirect()->route('admin-user-index');
    }

    public function create()
    {
        $cats = Category::all();
        return view('admin.user.create',compact('cats'));
    }

    public function store(StoreValidationRequest $request)
    {

        $user = new User;
        $input = $request->all();
            if ($file = $request->file('photo'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
            $input['photo'] = $name;
            }

            if($request->featured == "")
            {
                $input['featured'] = 0;
            }

            if(in_array(null, $request->title) || in_array(null, $request->details))
            {
                $input['title'] = null;
                $input['details'] = null;
            }
            else
            {
                $input['title'] = implode(',', $request->title);
                $input['details'] = implode(',', $request->details);
            }
            if(strpos($request->address,'&')===true)
            {
                $input['address'] = str_replace("&","and",$request->address);
            }
        if (!empty($request->special))
         {
            $input['special'] = implode(',', $request->special);
         }
        $input['password'] = bcrypt($request['password']);
        $user->fill($input)->save();
        Session::flash('success', 'New User added successfully.');
        return redirect()->route('admin-user-index');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $cats = Category::all();

        if($user->title!=null && $user->details!=null)
        {
            $title = explode(',', $user->title);
            $details = explode(',', $user->details);
        }
        else
        {
            $title = '';
            $details = '';
        }

        if($user->special != null)
        {
            $specials = explode(',', $user->special);
        }
        else
        {
            $specials = '';
        }

        return view('admin.user.edit',compact('user','cats','title','details','specials'));
    }

    public function update(UpdateValidationRequest $request,$id)
    {
        $input = $request->all();
        $user = User::findOrFail($id);
        if(!in_array(null, $request->title) && !in_array(null, $request->details))
        {
            $input['title'] = implode(',', $request->title);
            $input['details'] = implode(',', $request->details);
        }
        else
        {
            if(in_array(null, $request->title) || in_array(null, $request->details))
            {
                $input['title'] = null;
                $input['details'] = null;
            }
            else
            {
                $title = explode(',', $user->title);
                $details = explode(',', $user->details);
                $input['title'] = implode(',', $title);
                $input['details'] = implode(',', $details);
            }
        }
            if ($file = $request->file('photo'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
                if($user->photo != null)
                {
                    unlink(public_path().'/assets/images/'.$user->photo);
                }
            $input['photo'] = $name;
            }
        if (!empty($request->special))
         {
            $input['special'] = implode(',', $request->special);
         }
        if (empty($request->special))
         {
            $input['special'] = null;
         }
        if(!empty($input['password'])){
        $input['password'] = bcrypt($request['password']);

        }
        else{
         $input['password'] = $user->password;
        }
        if($request->featured == "")
        {
            $input['featured'] = 0;
        }
        $ck = strpos($request->address,'&');

            if($ck !== false)
            {
                $input['address'] = str_replace("&","and",$request->address);
            }

        $user->update($input);
        Session::flash('success', 'Successfully updated the User');
        return redirect()->route('admin-user-index');
    }

     public function InsuranceUpdate(Request $request)
    {



        $post = User::where('id','=',$request->handyman_id)->update(['insurance' => 1]);


$user = User::findOrFail($request->handyman_id);

$email = $user->email;

$user_name = $user->name. ' ' .$user->family_name;

$handyman_dash = url('/').'/handyman/dashboard';


             $headers =  'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Topstoffeerders <info@topstoffeerders.nl>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Insurance POD Approved!";
            $msg = "Dear Mr/Mrs ". $user_name .",<br><br>Your insurance pod has been approved. For further details visit your handyman panel through <a href='".$handyman_dash."'>here.</a><br><br>Kind regards,<br><br>Klantenservice Topstoffeerders";
            mail($email,$subject,$msg,$headers);



            $headers =  'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Topstoffeerders <info@topstoffeerders.nl>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Verzekering!";
            $msg = "Beste". $user_name .",<br><br>je verzekering status is goedgekeurd. Klik op account om de status van je wijziging te bekijken <a href='".$handyman_dash."'>account.</a><br><br>Met vriendelijke groet,<br><br>Klantenservice Topstoffeerders";
            mail($email,$subject,$msg,$headers);


        Session::flash('success', 'Successfully updated the User');
        return redirect()->route('admin-user-index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if($user->photo == null){
         $user->delete();
        Session::flash('success', 'Successfully deleted your User');
        return redirect()->back();
        }

        unlink(public_path().'/assets/images/'.$user->photo);
        $user->delete();
        Session::flash('success', 'Successfully deleted your User');
        return redirect()->back();
    }

    public function Insurance($id)
    {
        $user = User::findOrFail($id);
        $cats = Category::all();

        return view('admin.user.insurance',compact('user','cats'));
    }

    public function Details($id)
    {
        $user = User::findOrFail($id);

        $no = 0;



            $post = invoices::where('handyman_id','=',$id)->where('is_completed',1)->get();

            foreach ($post as $temp) {

                $no = $no + 1;
            }



        return view('admin.user.details',compact('user','no'));
    }

    public function ClientDetails($id)
    {
        $user = User::findOrFail($id);


        return view('admin.user.client_details',compact('user'));
    }
}


