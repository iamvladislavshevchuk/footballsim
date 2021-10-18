# Football Simulator
It's an open-source Laravel & React (TypeScipt) project for football simulation.

# Demo
Demo should be available here: https://footballsim.ai-40.com.

## Features
1) Fixture generator for any number of teams.
2) Game simulation based on team's strength.
3) Prediction algorythm based on simulation algorythm.
4) Simulate games week by week or the whole season altogether.
5) Edit games to see how it changes the prediction and the results.

## Installation
1) Clone the repository: `git clone https://github.com/iamvladislavshevchuk/footballsim`

### Backend
2) Install composer packages: `composer install`
3) Create an `.env` file based on `.env.example`. Fill in the information about the website: database, name etc.
4) Generate a unique key: `php artisan key:generate`
5) Migrate & seed the database: `php artisan migrate:fresh --seed`
6) Start the server: `php artisan serve`

### Frontend
7) Install npm packages: `npm i`
8) Create an `.env` file based on `.env.example`. Fill in the information about API.
9) Start the server: `npm start`