<?php

namespace App\Http\Controllers;

use App\Models\BillingDetails;
use App\Models\CustomerLogin;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Orderproduct;
use App\Models\Product;
use App\Models\social;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //done
        $today_sales = Order::whereDate('created_at' , Carbon::today())->sum('total');
        $yesterday_sales = Order::whereDate('created_at' , Carbon::yesterday())->sum('total');
        $this_week_sales = Order::whereDate('created_at', '>=', Carbon::today()->subDays(7))->sum('total');
        $this_month_sales = Order::whereDate('created_at', '>=', Carbon::today()->subDays(30))->sum('total');

        //line- chart
        $today_orders = Order::whereDate('created_at', '>=', Carbon::today())->count();
        $yesterday_orders = Order::whereDate('created_at' , Carbon::yesterday())->count();
        $this_week_orders = Order::whereDate('created_at', '>=', Carbon::today()->subDays(7))->count();
        $this_month_orderss = Order::whereDate('created_at', '>=', Carbon::today()->subDays(30))->count();

        //bar- chart
        $today_orders_product = Orderproduct::whereDate('created_at', '>=', Carbon::today())->count();
        $yesterday_orders_product = Orderproduct::whereDate('created_at' , Carbon::yesterday())->count();
        $this_week_orders_product = Orderproduct::whereDate('created_at', '>=', Carbon::today()->subDays(7))->count();
        $this_month_orders_product = Orderproduct::whereDate('created_at', '>=', Carbon::today()->subDays(30))->count();

        $total_discount = Order::whereDate('created_at', '>=', Carbon::today()->subDays(30))->sum('discount');
        $total_customer = CustomerLogin::whereDate('created_at' , '>=' , Carbon::today()->subDays(30))->count();
        $total_active_product = Inventory::groupBy('product_id')
        ->selectRaw('sum(quantity) as sum, product_id')
        ->havingRaw('sum >=1')
        ->count();

        $total_out_of_stock_product = Inventory::groupBy('product_id')
        ->selectRaw('sum(quantity) as sum, product_id')
        ->havingRaw('sum < 1')
        ->count();

        $total_stock_Warn_product = Inventory::groupBy('product_id')
        ->selectRaw('sum(quantity) as sum, product_id')
        ->havingRaw('sum <= 2')
        ->count();

        //pie chart
        $All_pending_orders = BillingDetails::where('status' , 'pending')->whereDate('created_at' , '>=' , Carbon::today()->subDays(365))->count();
        $All_processing_orders = BillingDetails::where('status' , 'processing')->whereDate('created_at' , '>=' , Carbon::today()->subDays(365))->count();
        $All_delivered_orders = BillingDetails::where('status' , 'delivered')->whereDate('created_at' , '>=' , Carbon::today()->subDays(365))->count();
        $All_cencel_orders = BillingDetails::where('status' , 'cencel')->whereDate('created_at' , '>=' , Carbon::today()->subDays(365))->count();

        return view('home', [
            'today_sales'=>$today_sales,
            'yesterday_sales'=>$yesterday_sales,
            'this_week_sales'=>$this_week_sales,
            'this_month_sales'=>$this_month_sales,
            'today_orders'=>$today_orders,
            'yesterday_orders'=>$yesterday_orders,
            'this_week_orders'=>$this_week_orders,
            'this_month_orderss'=>$this_month_orderss,
            'today_orders_product'=>$today_orders_product,
            'yesterday_orders_product'=>$yesterday_orders_product,
            'this_week_orders_product'=>$this_week_orders_product,
            'this_month_orders_product'=>$this_month_orders_product,
            'total_discount'=>$total_discount,
            'total_customer'=>$total_customer,
            'total_active_product'=>$total_active_product,
            'total_out_of_stock_product'=>$total_out_of_stock_product,
            'total_stock_Warn_product'=>$total_stock_Warn_product,
            'All_pending_orders'=>$All_pending_orders,
            'All_processing_orders'=>$All_processing_orders,
            'All_delivered_orders'=>$All_delivered_orders,
            'All_cencel_orders'=>$All_cencel_orders,
        ]);
    }


    //site_customization
    function site_customization(){
        $icons = array("fa-500px",
        "fa-amazon","fa-beer","fa-behance","fa-behance-square","fa-blind","fa-bluetooth","fa-bluetooth-b","fa-bolt","fa-book","fa-bookmark","fa-bookmark-o","fa-braille","fa-briefcase","fa-building","fa-building-o","fa-bullhorn","fa-bullseye","fa-bus","fa-buysellads","fa-calculator","fa-calendar",
        "fa-calendar-check-o","fa-calendar-minus-o","fa-calendar-o","fa-calendar-plus-o","fa-calendar-times-o","fa-camera","fa-camera-retro","fa-car","fa-caret-down","fa-caret-left","fa-caret-right",
        "fa-caret-square-o-down","fa-caret-square-o-left","fa-caret-square-o-right","fa-caret-square-o-up","fa-caret-up","fa-cart-arrow-down","fa-cart-plus","fa-cc","fa-cc-amex","fa-cc-diners-club",
        "fa-cc-discover","fa-cc-jcb","fa-cc-mastercard","fa-cc-paypal","fa-cc-stripe","fa-cc-visa","fa-certificate","fa-chain-broken","fa-check","fa-check-circle","fa-check-circle-o","fa-check-square",
        "fa-check-square-o","fa-chevron-circle-down","fa-chevron-circle-left","fa-chevron-circle-right","fa-chevron-circle-up","fa-chevron-down","fa-chevron-left","fa-chevron-right","fa-chevron-up","fa-child",
        "fa-chrome","fa-circle","fa-circle-o","fa-circle-o-notch","fa-circle-thin","fa-clipboard","fa-clock-o","fa-clone","fa-cloud","fa-cloud-download","fa-cloud-upload","fa-code","fa-code-fork","fa-codepen",
        "fa-codiepie","fa-coffee","fa-cog","fa-cogs","fa-columns","fa-comment","fa-comment-o","fa-commenting","fa-commenting-o","fa-comments","fa-comments-o","fa-compass","fa-compress","fa-connectdevelop",
        "fa-contao","fa-copyright","fa-creative-commons","fa-credit-card","fa-credit-card-alt","fa-crop","fa-crosshairs","fa-css3","fa-cube","fa-cubes","fa-cutlery","fa-dashcube","fa-database","fa-deaf",
        "fa-delicious","fa-desktop","fa-deviantart","fa-diamond","fa-digg","fa-dot-circle-o","fa-download","fa-dribbble","fa-dropbox","fa-drupal","fa-edge","fa-eercast","fa-eject","fa-ellipsis-h","fa-ellipsis-v",
        "fa-empire","fa-envelope","fa-envelope-o","fa-envelope-open","fa-envelope-open-o","fa-envelope-square","fa-envira","fa-eraser","fa-etsy","fa-eur","fa-exchange","fa-exclamation","fa-exclamation-circle",
        "fa-exclamation-triangle","fa-expand","fa-expeditedssl","fa-external-link","fa-external-link-square","fa-eye","fa-eye-slash","fa-eyedropper","fa-facebook","fa-facebook-official","fa-facebook-square",
        "fa-fast-backward","fa-fast-forward","fa-fax","fa-female","fa-fighter-jet","fa-file","fa-file-archive-o","fa-file-audio-o","fa-file-code-o","fa-file-excel-o","fa-file-image-o","fa-file-o","fa-file-pdf-o",
        "fa-file-powerpoint-o","fa-file-text","fa-file-text-o","fa-file-video-o","fa-file-word-o","fa-files-o","fa-film","fa-filter","fa-fire","fa-fire-extinguisher","fa-firefox","fa-first-order","fa-flag",
        "fa-flag-checkered","fa-flag-o","fa-flask","fa-flickr","fa-floppy-o","fa-folder","fa-folder-o","fa-folder-open","fa-folder-open-o","fa-font","fa-font-awesome","fa-fonticons","fa-fort-awesome","fa-forumbee",
        "fa-forward","fa-foursquare","fa-free-code-camp","fa-frown-o","fa-futbol-o","fa-gamepad","fa-gavel","fa-gbp","fa-genderless","fa-get-pocket","fa-gg","fa-gg-circle","fa-gift","fa-git","fa-git-square",
        "fa-github","fa-github-alt","fa-github-square","fa-gitlab","fa-glass","fa-glide","fa-glide-g","fa-globe","fa-google","fa-google-plus","fa-google-plus-official","fa-google-plus-square","fa-google-wallet",
        "fa-graduation-cap","fa-gratipay","fa-grav","fa-h-square","fa-hacker-news","fa-hand-lizard-o","fa-hand-o-down","fa-hand-o-left","fa-hand-o-right","fa-hand-o-up","fa-hand-paper-o","fa-hand-peace-o",
        "fa-hand-pointer-o","fa-hand-rock-o","fa-hand-scissors-o","fa-hand-spock-o","fa-handshake-o","fa-hashtag","fa-hdd-o","fa-header","fa-headphones","fa-heart","fa-heart-o","fa-heartbeat","fa-history",
        "fa-home","fa-hospital-o","fa-hourglass","fa-hourglass-end","fa-hourglass-half","fa-hourglass-o","fa-hourglass-start","fa-houzz","fa-html5","fa-i-cursor","fa-id-badge","fa-id-card","fa-id-card-o",
        "fa-ils","fa-imdb","fa-inbox","fa-indent","fa-industry","fa-info","fa-info-circle","fa-inr","fa-instagram","fa-internet-explorer","fa-ioxhost","fa-italic","fa-joomla","fa-jpy","fa-jsfiddle","fa-key",
        "fa-keyboard-o","fa-krw","fa-language","fa-laptop","fa-lastfm","fa-lastfm-square","fa-leaf","fa-leanpub","fa-lemon-o","fa-level-down","fa-level-up","fa-life-ring","fa-lightbulb-o","fa-line-chart",
        "fa-link","fa-linkedin","fa-linkedin-square","fa-linode","fa-linux","fa-list","fa-list-alt","fa-list-ol","fa-list-ul","fa-location-arrow","fa-lock","fa-long-arrow-down","fa-long-arrow-left",
        "fa-long-arrow-right","fa-long-arrow-up","fa-low-vision","fa-magic","fa-magnet","fa-male","fa-map","fa-map-marker","fa-map-o","fa-map-pin","fa-map-signs","fa-mars","fa-mars-double","fa-mars-stroke",
        "fa-mars-stroke-h","fa-mars-stroke-v","fa-maxcdn","fa-meanpath","fa-medium","fa-medkit","fa-meetup","fa-meh-o","fa-mercury","fa-microchip","fa-microphone","fa-microphone-slash","fa-minus",
        "fa-minus-circle","fa-minus-square","fa-minus-square-o","fa-mixcloud","fa-mobile","fa-modx","fa-money","fa-moon-o","fa-motorcycle","fa-mouse-pointer","fa-music","fa-neuter","fa-newspaper-o",
        "fa-object-group","fa-object-ungroup","fa-odnoklassniki","fa-odnoklassniki-square","fa-opencart","fa-openid","fa-opera","fa-optin-monster","fa-outdent","fa-pagelines","fa-paint-brush","fa-paper-plane",
        "fa-paper-plane-o","fa-paperclip","fa-paragraph","fa-pause","fa-pause-circle","fa-pause-circle-o","fa-paw","fa-paypal","fa-pencil","fa-pencil-square","fa-pencil-square-o","fa-percent","fa-phone",
        "fa-phone-square","fa-picture-o","fa-pie-chart","fa-pied-piper","fa-pied-piper-alt","fa-pied-piper-pp","fa-pinterest","fa-pinterest-p","fa-pinterest-square","fa-plane","fa-play","fa-play-circle",
        "fa-play-circle-o","fa-plug","fa-plus","fa-plus-circle","fa-plus-square","fa-plus-square-o","fa-podcast","fa-power-off","fa-print","fa-product-hunt","fa-puzzle-piece","fa-qq","fa-qrcode","fa-question",
        "fa-question-circle","fa-question-circle-o","fa-quora","fa-quote-left","fa-quote-right","fa-random","fa-ravelry","fa-rebel","fa-recycle","fa-reddit","fa-reddit-alien","fa-reddit-square","fa-refresh",
        "fa-registered","fa-renren","fa-repeat","fa-reply","fa-reply-all","fa-retweet","fa-road","fa-rocket","fa-rss","fa-rss-square","fa-rub","fa-safari","fa-scissors","fa-scribd","fa-search","fa-search-minus",
        "fa-search-plus","fa-sellsy","fa-server","fa-share","fa-share-alt","fa-share-alt-square","fa-share-square","fa-share-square-o","fa-shield","fa-ship","fa-shirtsinbulk","fa-shopping-bag","fa-shopping-basket",
        "fa-shopping-cart","fa-shower","fa-sign-in","fa-sign-language","fa-sign-out","fa-signal","fa-simplybuilt","fa-sitemap","fa-skyatlas","fa-skype","fa-slack","fa-sliders","fa-slideshare","fa-smile-o",
        "fa-snapchat","fa-snapchat-ghost","fa-snapchat-square","fa-snowflake-o","fa-sort","fa-sort-alpha-asc","fa-sort-alpha-desc","fa-sort-amount-asc","fa-sort-amount-desc","fa-sort-asc","fa-sort-desc",
        "fa-sort-numeric-asc","fa-sort-numeric-desc","fa-soundcloud","fa-space-shuttle","fa-spinner","fa-spoon","fa-spotify","fa-square","fa-square-o","fa-stack-exchange","fa-stack-overflow","fa-star",
        "fa-star-half","fa-star-half-o","fa-star-o","fa-steam","fa-steam-square","fa-step-backward","fa-step-forward","fa-stethoscope","fa-sticky-note","fa-sticky-note-o","fa-stop","fa-stop-circle",
        "fa-stop-circle-o","fa-street-view","fa-strikethrough","fa-stumbleupon","fa-stumbleupon-circle","fa-subscript","fa-subway","fa-suitcase","fa-sun-o","fa-superpowers","fa-superscript","fa-table",
        "fa-tablet","fa-tachometer","fa-tag","fa-tags","fa-tasks","fa-taxi","fa-telegram","fa-television","fa-tencent-weibo","fa-terminal","fa-text-height","fa-text-width","fa-th","fa-th-large","fa-th-list",
        "fa-themeisle","fa-thermometer-empty","fa-thermometer-full","fa-thermometer-half","fa-thermometer-quarter","fa-thermometer-three-quarters","fa-thumb-tack","fa-thumbs-down","fa-thumbs-o-down",
        "fa-thumbs-o-up","fa-thumbs-up","fa-ticket","fa-times","fa-times-circle","fa-times-circle-o","fa-tint","fa-toggle-off","fa-toggle-on","fa-trademark","fa-train","fa-transgender","fa-transgender-alt",
        "fa-trash","fa-trash-o","fa-tree","fa-trello","fa-tripadvisor","fa-trophy","fa-truck","fa-try","fa-tty","fa-tumblr","fa-tumblr-square","fa-twitch","fa-twitter","fa-twitter-square","fa-umbrella",
        "fa-underline","fa-undo","fa-universal-access","fa-university","fa-unlock","fa-unlock-alt","fa-upload","fa-usb","fa-usd","fa-user","fa-user-circle","fa-user-circle-o","fa-user-md","fa-user-o",
        "fa-user-plus","fa-user-secret","fa-user-times","fa-users","fa-venus","fa-venus-double","fa-venus-mars","fa-viacoin","fa-viadeo","fa-viadeo-square","fa-video-camera","fa-vimeo","fa-vimeo-square","fa-vine",
        "fa-vk","fa-volume-control-phone","fa-volume-down","fa-volume-off","fa-volume-up","fa-weibo","fa-weixin","fa-whatsapp","fa-wheelchair","fa-wheelchair-alt","fa-wifi","fa-wikipedia-w","fa-window-close",
        "fa-window-close-o","fa-window-maximize","fa-window-minimize","fa-window-restore","fa-windows","fa-wordpress","fa-wpbeginner","fa-wpexplorer","fa-wpforms","fa-wrench","fa-xing","fa-xing-square",
        "fa-y-combinator","fa-yahoo","fa-yelp","fa-yoast","fa-youtube","fa-youtube-play","fa-youtube-square");

        return view('admin.site_customization',[
            'icons'=>$icons,
        ]);
    }

    //social media icon upload
    function socal_media(Request $request){
        $request->validate([
            'page_link'=>'required',
            'social_icon'=>'required',
        ]);

        social::insert([
            'page_link'=>$request->page_link,
            'social_icon'=>$request->social_icon,
        ]);
        return back()->with('social' , 'Social Added Successfully');
    }

    // user
    function users(){
        $all_user = User::where('id','!=',auth::id())->paginate(6);
        $total_user = User::count();
        return view('admin.users.users' , compact('all_user','total_user'));
    }

    //active user user
    function active_users($user_id){
            User::find($user_id)->update([
            'status'=>1,
            ]);
        return back()->with('active', 'User Activated Successfully!');
    }

    //De-active user user
    function deactive_users($user_id){
            User::find($user_id)->update([
            'status'=>2,
            ]);
        return back()->with('deactive', 'User De-activated Successfully!');
    }

   //delete user
    function user_delete($user_id){
        User::find($user_id)->delete();
        return back()->with('delete', 'User Deleted Successfully!');
    }

    //add user
    function users_add(){
        return view('admin.users.add_user');
    }
    //insert user
    function insert_user(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required',
        ]);

        User::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'email_verified_at'=>carbon::now(),
            'created_at'=>carbon::now(),
        ]);
        return back()->with('success', 'User Added Successfully!');
    }
    // dashboard
    function dash(){
        return view('layouts.dashboard');
    }
    // profile
    function profile(){
        return view('admin.users.profile');
    }
    // name update
    function name_update(Request $request){
        User::find(Auth::id())->update([
            'name'=>$request->name,
            'updated_at'=>carbon::now(),
        ]);
        return back()->with('n_success', 'Name Updated Successfully!');
    }
     // password update
     function password_update(Request $request){
       $request->validate([
           'old_password'=>'required',
           'password'=>'required',
           'password'=>Password::min(8)
                            ->letters()
                            ->mixedCase()
                            ->numbers()
                            ->symbols(),
            'password'=>'confirmed',
       ]);

       if(Hash::check($request->old_password , Auth::user()->password)){
            if(Hash::check($request->password , Auth::user()->password)){
                return back()->with('same_pass', 'You already using this password!');
            }
            else{
                User::find(Auth::id())->update([
                    'password'=>bcrypt($request->password),
                    'updated_at'=>carbon::now(),
                ]);
                return back()->with('p_success', 'Password Updated Successfully!');
            }
       }
       else{
            return back()->with('wrong_pass', 'Old password dose not match');
       }

     }
     //photo update
     function photo_update(Request $request){
        $request->validate([
            'profile_photo'=> 'image',
            'profile_photo'=> 'file|max:4096',

        ]);

        $uploaded_photo = $request->profile_photo;
        $extension = $uploaded_photo->getClientOriginalExtension();
        $filename = Auth::id().'.'.$extension;

        if(Auth::user()->profile_photo == 'default.png'){
            Image::make($uploaded_photo)->save(public_path('/uploads/users/'.$filename));
            User::find(Auth::id())->update([
                'profile_photo'=>$filename,
            ]);
            return back()->with('photo_success', 'Photo Updated Successfully!');
        }
        else{
            $delete_from = public_path('/uploads/users/'.Auth::user()->profile_photo);
            unlink($delete_from);

            Image::make($uploaded_photo)->save(public_path('/uploads/users/'.$filename));
            User::find(Auth::id())->update([
                'profile_photo'=>$filename,
            ]);
            return back()->with('photo_success', 'Photo Updated Successfully!');
           }
     }
     //customer list
     function customer_list(){
         $all_customer = CustomerLogin::paginate(10);
         $total_customer = CustomerLogin::count();
        return view('admin.customer_list',[
            'all_customer'=>$all_customer,
            'total_customer'=>$total_customer,
        ]);
     }


     //reports
     //report by date
    public function reportByDate(Request $request){
        $request->validate([
            'date'=>'required',
        ],[
            'date.required'=>'Please select order date!',
        ]);

        $date = new DateTime($request->date);
        $formatDate = $date->format('d F Y');

        $orders = Order::where('order_date',$formatDate)->latest()->get();
        return view('reports',compact('orders'));
    }

    //report by month
    public function reportByMonth(Request $request){
        $request->validate([
            'month_name'=>'required',
            'year_name'=>'required',
        ],[
            'month_name.required'=>'Please select month!',
            'year_name.required'=>'Please select year!',
        ]);

        $orders = Order::where('order_month',$request->month_name)->where('order_year',$request->year_name)->latest()->get();
        return view('reports',compact('orders'));
    }

    //report by year
    public function reportByYear(Request $request){
        $orders = Order::where('order_year',$request->year_name)->latest()->get();
        return view('reports',compact('orders'));
    }
}
