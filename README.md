# Kann

Kann is a self hosted project management tool made for teams and developed with Laravel and Vue.


## Features

- User management by an administrator
- Team management with email invitations
- Permissions per team
- Project management with Kanban boards
- Two factor authentication
- Session management
- Light/dark mode toggle


## Screenshots

![Projects dashboard](https://private-user-images.githubusercontent.com/61262876/357220198-407ba344-985d-485c-abfd-4e489f02fa89.png?jwt=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTUiLCJleHAiOjE3MjM1MDI0MDgsIm5iZiI6MTcyMzUwMjEwOCwicGF0aCI6Ii82MTI2Mjg3Ni8zNTcyMjAxOTgtNDA3YmEzNDQtOTg1ZC00ODVjLWFiZmQtNGU0ODlmMDJmYTg5LnBuZz9YLUFtei1BbGdvcml0aG09QVdTNC1ITUFDLVNIQTI1NiZYLUFtei1DcmVkZW50aWFsPUFLSUFWQ09EWUxTQTUzUFFLNFpBJTJGMjAyNDA4MTIlMkZ1cy1lYXN0LTElMkZzMyUyRmF3czRfcmVxdWVzdCZYLUFtei1EYXRlPTIwMjQwODEyVDIyMzUwOFomWC1BbXotRXhwaXJlcz0zMDAmWC1BbXotU2lnbmF0dXJlPTJkMWMxZTI5OTVhYjdhYjBjZmY2YWZhNjBkYzg4YTlhYjE3MzRhYjc5ZDhlNTljYThlZWQ1ODNhY2JlZTY4YTMmWC1BbXotU2lnbmVkSGVhZGVycz1ob3N0JmFjdG9yX2lkPTAma2V5X2lkPTAmcmVwb19pZD0wIn0.Wpsc9xp45uSBZ2bOWehUVW_hJZaCDlfFCRTjeapnXfE)

![Team Settings](https://private-user-images.githubusercontent.com/61262876/357220206-32140448-fdcb-417f-ad3a-6d991999ce0e.png?jwt=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTUiLCJleHAiOjE3MjM1MDI0MDgsIm5iZiI6MTcyMzUwMjEwOCwicGF0aCI6Ii82MTI2Mjg3Ni8zNTcyMjAyMDYtMzIxNDA0NDgtZmRjYi00MTdmLWFkM2EtNmQ5OTE5OTljZTBlLnBuZz9YLUFtei1BbGdvcml0aG09QVdTNC1ITUFDLVNIQTI1NiZYLUFtei1DcmVkZW50aWFsPUFLSUFWQ09EWUxTQTUzUFFLNFpBJTJGMjAyNDA4MTIlMkZ1cy1lYXN0LTElMkZzMyUyRmF3czRfcmVxdWVzdCZYLUFtei1EYXRlPTIwMjQwODEyVDIyMzUwOFomWC1BbXotRXhwaXJlcz0zMDAmWC1BbXotU2lnbmF0dXJlPWYyODNiYTM5NWE3YzU1NTg4NWQ0MWFiY2NlODhlNjhiYWJhNWI0ZDhlNzM3MmI5ZmI4MzQwNjVlNGMxMGZjZDMmWC1BbXotU2lnbmVkSGVhZGVycz1ob3N0JmFjdG9yX2lkPTAma2V5X2lkPTAmcmVwb19pZD0wIn0.V-lvsldO07UwIv2aF4YdVKU_1B5nQsU19eCB1IjBt4A)

![Users table](https://private-user-images.githubusercontent.com/61262876/357220216-3797d0cb-8202-4478-a9b7-bd822ed2e9db.png?jwt=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTUiLCJleHAiOjE3MjM1MDI0MDgsIm5iZiI6MTcyMzUwMjEwOCwicGF0aCI6Ii82MTI2Mjg3Ni8zNTcyMjAyMTYtMzc5N2QwY2ItODIwMi00NDc4LWE5YjctYmQ4MjJlZDJlOWRiLnBuZz9YLUFtei1BbGdvcml0aG09QVdTNC1ITUFDLVNIQTI1NiZYLUFtei1DcmVkZW50aWFsPUFLSUFWQ09EWUxTQTUzUFFLNFpBJTJGMjAyNDA4MTIlMkZ1cy1lYXN0LTElMkZzMyUyRmF3czRfcmVxdWVzdCZYLUFtei1EYXRlPTIwMjQwODEyVDIyMzUwOFomWC1BbXotRXhwaXJlcz0zMDAmWC1BbXotU2lnbmF0dXJlPWRlNjExYWIzYTQxZGZjOGU4YTFlODVkNTdhYTNkNmZlNTVjYWU2YThjM2YzNGQzNjk3NjExOTUwZTMyZTQ4YTYmWC1BbXotU2lnbmVkSGVhZGVycz1ob3N0JmFjdG9yX2lkPTAma2V5X2lkPTAmcmVwb19pZD0wIn0.xrLxJYbvJUcWf6TAEVfQzHlb-XcoSYB3V91P2bjaH84)

![Project Kanban view](https://private-user-images.githubusercontent.com/61262876/357220234-52db3ba6-630b-452f-8d8a-bb57866f293f.png?jwt=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTUiLCJleHAiOjE3MjM1MDI0MDgsIm5iZiI6MTcyMzUwMjEwOCwicGF0aCI6Ii82MTI2Mjg3Ni8zNTcyMjAyMzQtNTJkYjNiYTYtNjMwYi00NTJmLThkOGEtYmI1Nzg2NmYyOTNmLnBuZz9YLUFtei1BbGdvcml0aG09QVdTNC1ITUFDLVNIQTI1NiZYLUFtei1DcmVkZW50aWFsPUFLSUFWQ09EWUxTQTUzUFFLNFpBJTJGMjAyNDA4MTIlMkZ1cy1lYXN0LTElMkZzMyUyRmF3czRfcmVxdWVzdCZYLUFtei1EYXRlPTIwMjQwODEyVDIyMzUwOFomWC1BbXotRXhwaXJlcz0zMDAmWC1BbXotU2lnbmF0dXJlPTBkODRjNzMwMGQxYzQzMWVjMmRmNGRiNDA0ODE4YThmODdiMzI5NTYwNGIwNGM1Y2U3Y2Y4YjI3OWJlMTUyOTImWC1BbXotU2lnbmVkSGVhZGVycz1ob3N0JmFjdG9yX2lkPTAma2V5X2lkPTAmcmVwb19pZD0wIn0.aoSHEkswarfnih3BAtKHV_883Iu2K7rvh5q8Z7Mkzdo)


## Demo

To try Kann you can use the [demo](https://kann.josuemartell.dev) site. Have in mind that all data is deleted everyday.


## Deployment

To deploy this project:

1. Clone the repository and cd into it
2. Install npm dependencies with `npm install`
3. Copy .env file from .env.example
4. Update admin credentials in .env file (see defalts in .env.example file)
5. Update email variables in .env file
6. Update db variables in .env file if necessary
7. Create database
8. Generate encryption key with `php artisan key:generate`
9. Migrate database with `php artisan migrate --seed`
10. If you want demo data enter `yes` otherwise select `no` if you only want to setup admin user
11. Install composer dependencies with `composer install --no-dev`
12. Run `php artisan optimize` to optimize Laravel for production
13. Run `php artisan storage:link` to create symbolic link for storage in public directory
14. Build frontend with `npm run build`


## Roadmap

- [ ] Update emails
- [ ] Add comments system to tasks
- [ ] Change styles in projects and tasks depending on how close to deadline
- [ ] Archiving system for users, projects and tasks
- [ ] Subscribing system to tasks


## License

[MIT](https://choosealicense.com/licenses/mit/)
