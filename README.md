📌 Agnibina Admission Coaching
একটি Laravel ভিত্তিক অ্যাডমিশন কোচিং ম্যানেজমেন্ট সিস্টেম, যেখানে শিক্ষার্থী, শিক্ষক ও প্রশাসকরা সহজেই সমস্ত কার্যক্রম পরিচালনা করতে পারবেন।

🌟 Features
✅ User Authentication – শিক্ষার্থী ও অ্যাডমিনের জন্য রেজিস্ট্রেশন ও লগইন ব্যবস্থা।
✅ Student Management – শিক্ষার্থীদের তথ্য সংরক্ষণ, আপডেট ও ম্যানেজ করার সুবিধা।
✅ Exam System – অনলাইন পরীক্ষা নেওয়ার ফিচার।
✅ Payment System – কোর্স ফি পরিশোধের ব্যবস্থা।
✅ Admin Panel – কোচিং পরিচালনার জন্য সম্পূর্ণ অ্যাডমিন ড্যাশবোর্ড।


🚀 Installation & Setup
প্রজেক্টটি সেটআপ করতে নিচের ধাপগুলো অনুসরণ করুন:

1️⃣ Clone the Repository
git clone https://github.com/tajul1234/agnibina.git
cd agnibina

2️⃣ Install Dependencies
composer install
npm install
3️⃣ Configure Environment
.env.example ফাইলটি .env নামে কপি করুন এবং নিচের কমান্ড চালান:
cp .env.example .env
php artisan key:generate

4️⃣ Setup Database
.env ফাইলে নিচের মত ডাটাবেজ কনফিগার করুন:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=

তারপর মাইগ্রেশন চালান:
php artisan migrate --seed
5️⃣ Run the Project
php artisan serve

এখন ব্রাউজারে গিয়ে http://127.0.0.1:8000 ভিজিট করুন।

📞 Contact
যদি কোনো সমস্যা হয়, তাহলে আমার সাথে যোগাযোগ করতে পারো:
📧 Email: tajul.cse.jkkniu@gmail.ccom
📱 Phone: +8801853991419

