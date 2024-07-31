<<<<<<< HEAD
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
=======
# prex-database-laravel-react
>>>>>>> 31a8ef57a6e27b2b2d0caa12aa2d7fef14eb7a00


Technologies Used:

Backend: Laravel 11

Frontend: React

Styling: Bootstrap

Authentication: Laravel Breeze

Database: MySQL

API Testing: Thunder


1. Admin Documentation

1.1 Introduction
This system is designed for cohort management by providing a platform for tracking applications, managing surveys, and displaying rounds data.

1.2 Getting Started
Cohorts: View and edit cohorts or see all entities related to the cohort as surveys and rounds, like in the following example
Rounds: Access applicants’ application for round1,2 to view, edit or delete it.
Surveys:  Access applicants’ application for surveys to view, edit or delete it.

1.3 User Roles and Permissions
Admin: Full access to all features.
applicants: fill round1, round2 and surveys forms

2. Developer Documentation
Project Overview
This system is designed for cohort management by providing a platform for tracking applications, managing surveys, and displaying rounds data.
CRUD “database project” research before starting the project
“Accessible for Skaipalms team only”
Backend: Laravel
Frontend: React
System analysis
Functional requirements:
Cohorts: admin can view and edit cohorts or see all entities related to the cohort as surveys and rounds
Rounds: admin can ccess applicants’ application for round 1,2 to view, edit or delete it.
Surveys: admin can access applicants’ application for surveys to view, edit or delete it.
Non-Functional Requirements:
1. Performance
 Frontend components are built with React to provide a dynamic and responsive user interface
Each component is a separate page so only the code needed for the current page is loaded, therefore the overall performance of the application improves
“Lazy Loading”
while backend APIs are designed to return data efficiently, minimizing latency by: 
log Analysis: Review logs for slow queries or errors that may impact performance.
Review Query Performance: Analyze and optimize database queries to ensure they are efficient. Use database indexing, optimize query structures, and avoid unnecessary joins or complex subqueries.
Selective Data Fetching: only the necessary data is fetched and returned. Avoid sending large datasets if only a subset is needed.
2. Security
The system employs authentication and authorization mechanisms to ensure that only authorized users can access sensitive data. This includes the use of Laravel's built-in authentication features and secure password hashing “breeze library”
CSRF protections “Cross-Site Request Forgery is an attack that forces an end user to execute unwanted actions on a web application in which they're currently authenticated.”.
6. Maintainability
Documentation: technical documentation is provided for developers, including code comments, API documentation, 
Version Control: The use of version control systems (e.g., Git) ensures that changes are tracked and managed effectively, allowing for easy rollback and collaboration.
7. Data Integrity
Backup and Recovery: Regular backups are performed to protect against data loss, and recovery procedures are tested to ensure that data can be restored accurately in case of corruption or loss.
“Not found yet, but to be implemented later”

EERD

creating generalized classes or tables that encapsulate common attributes or behaviors, reduce redundancy and make the system easier to maintain. Any changes to the generalized entity need to be made in only one place.
Specialized classes or tables inherit from generalized ones, help in extending functionality without modifying the existing generalized structure. This promotes a clean and organized codebase.
Mapping



UI
Figma UI
https://www.figma.com/design/OQ8tk1X8eiQUgkoX9zixdn/Untitled?node-id=0-1&t=PyZyp57YslA9o5Tf-1
Implementation

Routes:

Route::get('/applicant/details/{id}', [ApplicantController::class, 'getApplicantDetails']);


Route::resource('cohorts', CohortController::class);
Route::resource('applicants', ApplicantController::class);
Route::resource('surveys', SurveyController::class);
Route::resource('followupSurvey', FollowupSurveyController::class);
Route::resource('onboardingSurvey', OnboardingSurveyController::class);
Route::resource('round1', Round1Controller::class);
Route::resource('round2', Round2Controller::class);
Route::resource('round3', Round3Controller::class);


Route::get('round1/getByCohort/{cohortId}', [Round1Controller::class, 'getByCohort']);
Route::get('round2/getByCohort/{cohortId}', [Round2Controller::class, 'getByCohort']);
Route::get('round3/getByCohort/{cohortId}', [Round3Controller::class, 'getByCohort']);
Route::get('followupSurvey/getByCohort/{cohortId}', [FollowupSurveyController::class, 'getByCohort']);
Route::get('onboardingSurvey/getByCohort/{cohortId}', [OnboardingSurveyController::class, 'getByCohort']);

getByCohort function example in round 1 controller:
public function getByCohort($cohortId)
{
    $round1s = Round1::with('applicant')->where('cohort_id', $cohortId)->get();
    return response()->json($round1s);
}

getApplicantDetails function in applicant controller:
public function getApplicantDetails($id)
{
    try {
        $applicant = Applicant::with('round1', 'round2', 'round3')->find($id);
        return response()->json($applicant);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error fetching applicant details'], 500);
    }
}


Future Work
automate the backup process to ensure regular and reliable backups of critical data.
Including more companies with Prex
Mobile responsiveness
technical documentation will be expanded to include detailed explanations of new features, updates
Perform regular security audits and vulnerability assessments to keep the application secure.
Let admins add comments for each applicant and his/her own final decision.
Add applicant’s data for previous cohorts.
Add charts for calculated percentage.
Enhance UI/UX
Make the code cleaner
Enhance the security
Making the system diagrams more consistent
Continues testing 


Contact
For any questions or feedback, please contact at maryammohamedauf@gmail.com