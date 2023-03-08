<?php
use App\Http\Controllers\BarndController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ChildcategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoleManagement;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


//verify user email
Auth::routes([
    'verify' => true,
    'login' => false,
]);
Route::get('/admin/my-login/', [LoginController::class, 'showLoginForm'])->name('login');
Route::Post('/login/admin/', [LoginController::class, 'login'])->name('login');
Route::get('/register/admin', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register/admin', [RegisterController::class,'register'])->name('register');

// Route::get('/password/reset/admin', [ForgotPasswordController::class, 'reset']);
// Route::POST('/password/email', [ForgotPasswordController::class, 'reset']);
// Route::POST('/password/reset/admin/{token}', [ResetPasswordController::class, 'reset']);
// Route::POST('/password/reset/admin/post', [ResetPasswordController::class, 'reset']);


//front page
Route::get('/', [FrontendController::class, 'index'])->name('index');

//shop page
Route::get('/shop', [FrontendController::class, 'shop'])->name('shop');


//front page
Route::get('/about-Us', [FrontendController::class, 'about_us'])->name('about.us');

//front page
Route::get('/contact-Us', [FrontendController::class, 'contact_us'])->name('contact.us');

//front page
Route::get('/privacy-policy', [FrontendController::class, 'privacy_policy'])->name('privacy.policy');

//product details
Route::get('/product/details/{product_id}', [FrontendController::class, 'product_details'])->name('product.details');

//product by category
Route::get('/shop/{id}', [FrontendController::class, 'product_by_category']);

//Image Carosuel insert
Route::POST('/image/Carosuel/insert/', [FrontendController::class, 'image_Carosuel_insert'])->name('image.Carosuel.insert');
//photos and banner
Route::get('/add/banner/photos/', [FrontendController::class, 'add_banner_photos'])->name('add.banner.photos');

//Image Carosuel delete
Route::get('/banner/delete/{carousel_id}', [FrontendController::class, 'banner_delete'])->name('banner.delete');
// active carousel_image
Route::get('/active/carousel/{carousel_id}', [FrontendController::class, 'carousel_active']);
// Deactive carousel_image
Route::get('/deactive/carousel/{carousel_id}', [FrontendController::class, 'carousel_deactive']);

//get size ajax product details
Route::post('/getSize', [FrontendController::class, 'getSize']);
Route::post('/getSizes', [FrontendController::class, 'getSizes']);
Route::post('/stock', [FrontendController::class, 'stock']);
Route::post('/stocks', [FrontendController::class, 'stocks']);


//customer password reset
Route::get('/password/reset/customer', [CustomerController::class, 'pass_reset'])->name('pass.reset');

//sent password reset link
Route::POST('/password/reset/link', [CustomerController::class, 'pass_reset_link'])->name('pass.reset.link');

//customer password reset form
Route::get('/password/reset/form/{token}', [CustomerController::class, 'pass_reset_form'])->name('pass.reset.form');

//customer password reset update
Route::post('/password/reset/form/update', [CustomerController::class, 'pass_reset_update'])->name('pass.reset.update');

//customer sub,itted form
Route::post('/customer/form/submit/', [CustomerController::class, 'customer_form'])->name('customer.form');

//customer submitted form
Route::get('/customer/form/view', [CustomerController::class, 'customer_form_view'])->name('customer.form.view');

//customer submitted form
Route::get('/customer/form/delete/{id}', [CustomerController::class, 'customer_form_delete'])->name('customer.form.delete');

//customer list form
Route::get('/customer/list/delete/{id}', [CustomerController::class, 'customer_list_delete'])->name('customer.list.delete');

//after login front page
Route::get('/home', [HomeController::class, 'index'])->middleware('authactive')->name('home');

//site customization
Route::get('/site/customization', [HomeController::class, 'site_customization'])->name('site.customization');
Route::POST('/social-media/upload', [HomeController::class, 'socal_media'])->name('socal.media');

// users
Route::get('/users', [HomeController::class, 'users'])->name('user');

// active users
Route::get('/active/user/{user_id}', [HomeController::class, 'active_users']);
// Deactive users
Route::get('/deactive/user/{user_id}', [HomeController::class, 'deactive_users']);

//add user
Route::get('/users/add', [HomeController::class, 'users_add'])->name('user.add.index');

//insert user
Route::post('/insert/user', [HomeController::class, 'insert_user'])->name('insert.user');

//user delete
Route::get('/user/delete/{user_id}', [HomeController::class, 'user_delete'])->name('user.delete');

//profile
Route::get('/profile', [HomeController::class, 'profile'])->name('profile');

//name update
Route::post('/name/update', [HomeController::class, 'name_update']);

//password update
Route::post('/password/update', [HomeController::class, 'password_update']);

//photo update
Route::post('/photo/update', [HomeController::class, 'photo_update']);

//customer_list
Route::get('/customer/list/', [HomeController::class, 'customer_list'])->name('customer.list');


// category
Route::get('/category', [CategoryController::class,'add_category'])->name('add.category');

//category insert
Route::post('/category/insert', [CategoryController::class,'insert']);

//category soft delete
Route::get('/category/delete/{category_id}', [CategoryController::class,'delete'])->name('category.soft.delete');

//category delete
Route::get('/category/edit/{category_id}', [CategoryController::class,'edit'])->name('category.edit');

//category update
Route::post('/category/update', [CategoryController::class,'update']);

//trash category
Route::get('/category/trash', [CategoryController::class,'trash'])->name('category.trash');

//category restore from trash
Route::get('/category/restore/{category_id}', [CategoryController::class,'restore'])->name('category.restore');

//category hard delete
Route::get('/category/hard_delete/{category_id}', [CategoryController::class,'hard_delete'])->name('category.hard.delete');

//mark delete
Route::post('/mark/delete', [CategoryController::class,'mark_delete'])->name('mark.delete');

//mark trash delete
Route::post('/mark/trash/delete', [CategoryController::class,'mark_trash_delete'])->name('mark.trash.delete');

//sub category
Route::get('/subcategory', [SubcategoryController::class, 'sub_category'])->name('add.sub.category');

//sub category insert
Route::post('/subcategory/insert', [SubcategoryController::class, 'sub_category_insert']);

//sub category edit
Route::get('/subcategory/edit/{subcategory_id}', [SubcategoryController::class, 'sub_category_edit'])->name('edit.subcategory');

//sub category update
Route::post('/subcategory/update', [SubcategoryController::class, 'sub_category_update']);

//sub category delete
Route::get('/subcategory/delete/{subcategory_id}', [SubcategoryController::class, 'sub_category_delete'])->name('subcategory.soft.delete');

//sub category Trash
Route::get('/Subcategory/trash', [SubcategoryController::class, 'sub_category_trash'])->name('trash.sub.category');

//category restore from trash
Route::get('/subcategory/restore/{subcategory_id}', [SubCategoryController::class,'restore'])->name('subcategory.restore');

//subcategory hard delete
Route::get('/subcategory/hard_delete/{subcategory_id}', [SubcategoryController::class,'hard_delete'])->name('subcategory.hard.delete');



//child category
Route::get('/childcategory' , [ChildcategoryController::class , 'child_category'])->name('add.child.category');

//child category insert
Route::post('/childcategory/insert' , [ChildcategoryController::class , 'child_category_insert']);

//child category edit
Route::get('/childcategory/edit/{childcategory_id}', [ChildcategoryController::class, 'child_category_edit'])->name('edit.childcategory');

//child category update
Route::post('/childcategory/update', [ChildcategoryController::class, 'child_category_update']);

//child category delete
Route::get('/childcategory/delete/{childcategory_id}', [ChildcategoryController::class, 'child_category_delete'])->name('childcategory.soft.delete');

//trash childcategory
Route::get('/childcategory/trash' , [ChildcategoryController::class , 'child_category_trash'])->name('trash.child.category');

//child category restore from trash
Route::get('/child-category/restore/{childcategory_id}', [ChildcategoryController::class,'restore'])->name('childcategory.restore');

//child category hard delete
Route::get('/child-category/hard_delete/{childcategory_id}', [ChildcategoryController::class,'hard_delete'])->name('childcategory.hard.delete');

//add brand
Route::get('/add/brand', [BarndController::class,'add_brand'])->name('add.brand');
Route::POST('/brand/insert', [BarndController::class,'brand_insert']);
Route::get('/brand/edit/{brand_id}', [BarndController::class,'brand_delete'])->name('brand.delete');


//add product
Route::get('/add/product', [ProductController::class, 'add_product'])->name('add.product');

//product list
Route::get('/product/list', [ProductController::class, 'product_list'])->name('product.list');

//product delete
Route::get('/product/delete/{product_id}', [ProductController::class, 'delete'])->name('product.delete');
//product edit
Route::get('/product/edit/{product_id}', [ProductController::class, 'edit_product'])->name('edit.product');

//ajax get sub category
Route::post('/getSubcategory', [ProductController::class, 'getSubcategory']);

//ajaz get child chategory
Route::post('/getChildcategory', [ProductController::class, 'getChildcategory']);

//product insert
Route::post('/product/insert', [ProductController::class, 'product_insert']);

//product update
Route::post('/product/update', [ProductController::class, 'product_update']);


// inventory-> add color and size
Route::get('/add/color-size', [InventoryController::class, 'add_color_size'])->name('add.color.size');

//add color to data base
Route::post('/insert_color', [InventoryController::class, 'insert_color']);

//add size to data base
Route::post('/insert_size', [InventoryController::class, 'insert_size']);

//product Inventory
Route::get('/inventory/{product_id}', [InventoryController::class, 'inventory'])->name('product.inventory');

Route::post('/insert/inventory', [InventoryController::class, 'inventory_insert']);

//color delete
Route::get('/color/delete/{color_id}', [InventoryController::class,'color_delete'])->name('color.delete');

//size delete
Route::get('/size/delete/{size_id}', [InventoryController::class,'size_delete'])->name('size.delete');

//inventory delete
Route::get('/inventory/delete/{inventory_id}', [InventoryController::class,'inventory_delete'])->name('inventory.delete');

//inventory edit
Route::get('/inventory/inventory/edit/{inventory_id}', [InventoryController::class,'inventory_edit'])->name('inventory.edit');

//inventory update
Route::POST('/inventory/update/', [InventoryController::class,'inventory_update'])->name('inventory.update');

//meta tags insert
Route::post('/insert/tags', [InventoryController::class, 'tags']);
//meta tags delete
Route::get('/tags/delete/{tags}', [InventoryController::class, 'tags_delete'])->name('tags.delete');


//customer login
Route::get('/customer/register', [CustomerRegisterController::class, 'customer_register'])->name('customer.register');
Route::post('/customer/insert', [CustomerRegisterController::class, 'customer_insert'])->name('customer.insert');
Route::post('/customer/login/post', [CustomerLoginController::class, 'customer_login'])->name('customer.login');
Route::get('/customer/logout', [CustomerLoginController::class, 'customer_logout'])->name('customer.logout');


//customer account
Route::get('/customer/account', [CustomerController::class, 'customer_account'])->name('customer.account');
Route::get('/invoice/download/{order_id}', [CustomerController::class, 'invoice_download'])->name('invoice.download');
Route::post('/customer/account/update', [CustomerController::class, 'customer_account_update'])->name('customer.account.update');

// cart
route::get('/cart/', [CartController::class, 'cart_view'])->name('cart.view');
route::post('/cart/store', [CartController::class, 'cart_store'])->name('cart.store');
route::post('/cart/update', [CartController::class, 'cart_update'])->name('cart.update');
route::get('/cart/remove/{cart_id}', [CartController::class, 'cart_remove'])->name('cart.remove');




//wishlist
route::get('/wishlist/', [WishlistController::class, 'wishlist'])->name('wishlist');
route::post('/wishlist/store', [WishlistController::class, 'wishlist_store'])->name('wishlist.store');
route::post('/wishlist/update', [WishlistController::class, 'wishlist_update'])->name('wishlist.update');
route::get('/wishlist/remove/{wishlist_id}', [WishlistController::class, 'wishlist_remove'])->name('wishlist.remove');

//checkout
route::get('/checkout/', [CheckoutController::class, 'checkout'])->name('checkout');
route::post('/getCity', [CheckoutController::class, 'getCity']);
route::post('/checkout/insert', [CheckoutController::class, 'checkout_insert'])->name('checkout.insert');
route::get('/order/success', [CheckoutController::class, 'order_success'])->name('order.success');


//coupon
route::get('/coupon/', [CouponController::class, 'coupon'])->name('coupon');
route::get('/coupon/edit/{coupon_id}', [CouponController::class, 'coupon_edit'])->name('coupon.edit');
route::post('/coupon/insert/', [CouponController::class, 'coupon_add']);
route::post('/upto/coupon/insert/', [CouponController::class, 'upto_coupon_add']);
route::post('/coupon/update/', [CouponController::class, 'coupon_update']);
Route::get('/coupon/delete/{inventory_id}', [CouponController::class,'coupon_delete'])->name('coupon.delete');


// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/ssl/pay/', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

//stripe payment
Route::get('stripe', [StripePaymentController::class, 'stripe']);
Route::post('stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');


//review insert
Route::post('/review/insert/', [FrontendController::class, 'review'])->name('review.insert');

Route::get('/customer/reviews/', [ReviewController::class, 'show_review'])->name('show.reviews');

//customer review delete
Route::get('/customer/review/delete/{id}', [ReviewController::class, 'customer_review_delete'])->name('customer.review.delete');

//email verify
Route::get('/email/verify/{token}', [CustomerRegisterController::class, 'email_verify']);


//github login
Route::get('/github/redirect', [GithubController::class, 'redirectToProvider']);
Route::get('/github/callback', [GithubController::class, 'handleToProviderCallback']);

//google login
Route::get('/google/redirect', [GoogleController::class, 'redirectToProvider']);
Route::get('/google/callback', [GoogleController::class, 'handleToProviderCallback']);

//facebook login
Route::get('/facebook/redirect', [FacebookController::class, 'redirectToProvider']);
Route::get('/facebook/callback', [FacebookController::class, 'handleToProviderCallback']);

//role management
Route::get('/role/management', [RoleManagement::class, 'role_management'])->name('role.management');
Route::post('/add/permission', [RoleManagement::class, 'add_permission'])->name('add.permission');
Route::post('/add/role', [RoleManagement::class, 'add_role'])->name('add.role');
Route::post('/assaign/role', [RoleManagement::class, 'assaign_role'])->name('assaign.role');
Route::get('/edit/permissions/{user_id}', [RoleManagement::class, 'edit_permissions'])->name('edit.permissions');
Route::post('/update/permission/', [RoleManagement::class, 'update_permission'])->name('update.permission');
Route::get('/remove/role/{user_id}', [RoleManagement::class, 'remove_role'])->name('remove.role');
Route::get('/edit/permission/{role_id}', [RoleManagement::class, 'edit_permission'])->name('edit.permission');
Route::post('/update/role/permission/', [RoleManagement::class, 'update_role_permission'])->name('update.role.permission');


//promotion
Route::get('/email/promotion/', [PromotionController::class, 'email_promotion'])->name('email.promotion');
Route::get('/sms/promotion/', [PromotionController::class, 'sms_promotion'])->name('sms.promotion');

Route::post('/insert/email/', [PromotionController::class, 'insert_email'])->name('insert.email');
Route::post('/insert/number/', [PromotionController::class, 'insert_number'])->name('insert.number');

Route::post('/send/promo/email/', [PromotionController::class, 'send_promo_email'])->name('send.promo.email');
Route::post('/send/promo/sms/', [PromotionController::class, 'send_promo_sms'])->name('send.promo.sms');

Route::get('/email/delete/{email_id}', [PromotionController::class, 'email_delete'])->name('email.delete');
Route::get('/sms/delete/{sms_id}', [PromotionController::class, 'sms_delete'])->name('sms.delete');


//order management
Route::get('/pending/orders/', [OrderController::class, 'pending_orders'])->name('pending.orders');
Route::get('/processing/orders/', [OrderController::class, 'processing_orders'])->name('processing.orders');
Route::get('/delivered/orders/', [OrderController::class, 'delivered_orders'])->name('delivered.orders');
Route::get('/cencel/orders/', [OrderController::class, 'cencel_orders'])->name('cencel.orders');
Route::get('/orders/view/{order_id}', [OrderController::class, 'orders_view'])->name('orders.view');
Route::post('/update/status/', [OrderController::class, 'update_status'])->name('update.status');
Route::get('/all-orders', [OrderController::class, 'all_order'])->name('all.order');

//reports
Route::post('reports/by-date',[HomeController::class,'reportByDate'])->name('search-by-date');
Route::post('reports/by-month',[HomeController::class,'reportByMonth'])->name('search-by-month');
Route::post('reports/by-year',[HomeController::class,'reportByYear'])->name('search-by-year');

//paypal
Route::get('/paypal',function(){
    return view('myOrder');
});
// route for processing payment
Route::post('/paypal', [PaymentController::class, 'payWithpaypal'])->name('paypal');
// route for check status of the payment
Route::get('/status', [PaymentController::class, 'getPaymentStatus'])->name('status');
