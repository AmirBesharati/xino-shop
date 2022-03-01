<div dir="rtl" style="text-align:right;">

#لطفا اول داکیومنت خوانده شود

#سلام بر دوست عزیزی که داری اینو میخونی امیدوارم حالت خوب باشه
#این یه پروژه با توجه به نیاز مندی های گفته شده میباشد اول خواستم انگلیسی بنویسم گفتم وللش تا وقتی فارسی هست چرا انگلیسی :) 


#نکات 
- من از migration استفاده نمیکنم چون همیشه مقدار تغییراتم زیاده روی دیتابیس از خود phpstorm استفاده میکنم برای ساخت و مدیریت دیتا بیس و چیزی برای migrate وجود نداره باید دذیتا بیس import بشود 
- همه ریکوست های نیاز به client-token دارن که فرانت باید ساخته بشه و middlware اگر ساخته تشده باشه یهدونه میسازه و برمیگردونه همونو توی header بزارید با کلید client-token 
- من نمیدونستم در آخر قراره authentication الزامی باشه واسه پرداخت یا خیر ولی من روی دو حالت بدون ورود و با ورود پیاده سازی کردم کل روند رو (اولیوت با یوزر احراز شده هستش) 
- واسه auth از لاراول passport استفاده شده و روت های auth گذاشته شده   
- همه چی کامنت گذاری شده و فانکشن ها از اسمشون معلومه چیکار میکنن 
- همممم در آخر هم که بگم همه ی کلاس ها بجر کلا های کوئری بیلدر طی کار برروی پروژه نوشته شده و کپی نشده
- از هیچ پکیج جانبی جز laravel passport استفاده نشده 
- نسخه ی لاراول هم 7.x هستش پس نیاز به php 7.4 هست و کامپوز منطبق با اون ورژن php 
- بصورت پیش فرض کلاینت توکن و Bareer Token  برای احراز در جی سان موجود است 

#تست
#Login
- user : amirbesharati59@gmail.com
- pass : passpass
- id : 51

#postman 
- /Xino.postman_collection.json


# روند ها 
- لیست محصولات گرفته میشود از api و محصول انتخاب میگردد 
- پس از انتخاب محصول آیدی محصول برای افزودت به سبد به api فرستاده میشود 
- با توجه به احراز بودن یا نبودن کاربر به سبد کاربر یا بازدید کننده اضافه خواهد شد در صورتی که دوبار از یک محصول به سبد اضافه شود اولی باقی میماند و در تعداد سفارش تغغیری رخ نمیدهد 
- در صورتی که بخواهید از یک محصول بیش از یک عدد سفارش دهید باید مقدار count به سمت api ارسال شود بصورت پیش فرض این مقدار برابر با 1 می باشد.
- آدرس cart-items جهت نمایش موجودی سبذ فعلی کاربر یا بازدید کننده است 
- ساخت فاکتور : در صورتی که به این آدرس درخواست زده شود موجودیت های درون سبد چک میشود و در صورت عدم تغییر موجودیت ها فاکتور ساخته میشود 
- شما می توانید لیست فاکتور های هر کاربر یا بازدید گننده را توسط factor list دریافت کنید.
- برای پرداخت از factor pay استفاده شود سیستم پرداختی موجود نبوده و بصورت پیش فرض در صورتی که فاکتور در استاتوس منتظر پرداخت باشد پرداخت می شود در غیر این صورت با اررور مواجه خواهید شد


</div>

<div> 

#Classes
#API Classes
- WebserviceResponse : this is a response Class to Manage all response statuses and messages. in this class we defined response statuses and messages as a constant variable to make code readable and easier and scalable

#Helper Classes
- HelperHash : This class responsibility is that to make hash from array of data with this methodology we can decrypt hash and mine the hash data (it used in factor to generate follow up code for each factor)

#Managers
- CartManager : it handled all user/client cart processes in cart manager such as add product to cart or delete or edit cart

- FactorManager : it handled all user/client factor processes in factor manager class such as make factor or factor contents

- RedisManager : it helps us to manage all keys of our redis with defining keys as constant variable in RedisManager (by default its not available you should turn it on in database configs)

#QueryBuilders (this is my favorite part)
General Description
These Classes were write by my self many years ago and i didnt change it alot but the responsibity of these classes are making queries and make query writing easy-peasy for php programmers its very important to me that u read these class and how they work 

#HTTP CONTROLLERS
- AuthController : Auth Methods such as login/register Are in this class.
- CartController : All Cart methods are in this class.
- FactorController : All Factor methods are in this class.
- ProductController : All Product methods are in this class.
- UserController : All User methods are in this class.


#Middleware (middlewares that I wrote)
- ClientTokenMiddleware : check client token and keep away clients without client-token

#Models
- Cart : Basket or Cart of user params are mentioned as @params in the model 
- Client : if user not authenticated we know it as client and we store clients have their cart and etc in out database 
- Factor : Factor of user with price and client_id or user_id. other params mentioned as @params in the model
- FactorContent : its a Model to save products that the user want to buy or bought them (we replicate product in this model because the product can change after a while or disappear)
- Product : Product Model Nothing More
-   User : User model Nothing More




</div>


