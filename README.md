 📌 Installation Steps

 1. Clone project


git clone https://github.com/ahlamali25/finishedZayd.git

cd finishedZayd


---

 2. Install dependencies


composer install


---

 3. Create environment file


cp .env.example .env


Then configure database credentials inside `.env`

---

 4. Generate application key


php artisan key:generate


---

 5. Run migrations


php artisan migrate


---

 6. Seed database (important)


php artisan db:seed


---

 7. Link storage


php artisan storage:link


---

 8. Run queue worker (IMPORTANT for notifications)


php artisan queue:work


---

 9. Start server


php artisan serve


---

 👤 Default Accounts

* Admin: [admin@gmail.com](mailto:admin@gmail.com)
* Teacher: [jumanah@gmail.com](mailto:jumanah@gmail.com)

---

 ⚙️ Notes

 Mail Configuration (Mailtrap)

This project uses Mailtrap for email testing.

Steps:

1. Create account on Mailtrap
2. Get SMTP credentials
3. Add them to `.env`:


MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=null


---

# 🚀 Features

* User Authentication
* Role Management (Admin / Teacher / Student)
* Courses & Lessons Management
* Class Groups
* Notifications System
* Email system (Mailtrap)
