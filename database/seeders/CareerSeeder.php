<?php

namespace Database\Seeders;

use App\Models\Career;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Career::insert([
            [
                "title" => "Senior Backend Engineer - PHP & Laravel",
                "description" => "Key Responsibilities:

Develop and maintain server-side code and databases for web applications using PHP
Collaborate with architects and senior engineers to design and implement scalable, efficient system architectures tailored to business requirements
Conduct thorough code reviews and provide constructive feedback to maintain code quality, scalability, and security
Troubleshoot and resolve production issues, performance bottlenecks, and bugs in a timely manner
Write unit and integration tests using PHPUnit or similar tools to ensure the reliability and stability of the codebase


Requirements

Bachelor's degree in Computer Science, Software Engineering, or a related field
4+ years of experience as a Backend Engineer, with a strong focus on PHP development
Proficiency with PHP frameworks such as Laravel
Solid experience with relational databases MySQL, including writing complex queries and performance optimization
Familiarity with front-end technologies, including Livewire, HTML5, CSS3, JavaScript, and jQuery
Hands-on experience with building and integrating REST APIs, GraphQL, and third-party services
Basic knowledge of CI/CD is a plus
Strong understanding of version control systems like Git and best practices in branching and merging
Strong problem-solving skills, attention to detail, and ability to work in a collaborative team environment",
                "department_id" => 2,
                "status" => "open",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "title" => "Software Engineer",
                "description" => "Fluent communication skills in English 

Strong problem-solving skills, attention to detail, and ability to work independently as well as collaboratively in a team environment.
Excellent communication and interpersonal skills, with the ability to effectively communicate technical concepts to non-technical stakeholders.
Passion for learning, self-motivation, and willingness to take on new challenges in a dynamic startup environment.
Experience working in a Startup or entrepreneurial setting is a plus.


 YOUR SKILL QUALIFICATIONS

Proven experience as a Full Stack Developer, with strong proficiency in .NET and React development.
Solid understanding of software development principles, design patterns, and architectural concepts.
Hands-on experience with .NET Core, C#, ASP.NET MVC/WebAPI, Entity Framework, SQL Server.
Proficiency in front-end dev. using HTML, CSS, JavaScript, React, Redux, and related technologies.
Experience with version control systems (e.g., Git), agile methodologies (e.g., Scrum, Kanban), and DevOps practices.


PREVIOUS EXPERIENCE 
 
Minimum 5 years in Web full-stack development

Bachelor’s degree in computer science, Engineering, or a related field (or equivalent work experience).
Experience with construction industry a plus
Experience with mobile development a plus 


WHAT YOU’LL BE DOING

Develop and maintain web applications using .NET Core, C#, ASP.NET MVC, React, and other relevant technologies.
Design and implement responsive and user-friendly front-end interfaces using HTML, CSS, JavaScript, and modern front-end frameworks/libraries.
Create RESTful APIs and integrate with backend services to support seamless data exchange and functionality.
Collaborate with product managers, designers, and other stakeholders to understand requirements, define user stories, and prioritize features.
Participate in the entire software development lifecycle, including planning, design, development, testing, deployment, and maintenance.
Write clean, efficient, and well-documented code following coding standards and best practices.
Conduct code reviews, provide constructive feedback, and mentor junior developers to foster a culture of continuous improvement and learning.
Troubleshoot and debug issues, perform root cause analysis, and implement effective solutions to address technical challenges.
Stay up to date with emerging technologies, trends, and industry best practices to drive innovation and maintain a competitive edge.
Work in a fast-paced, agile environment, adapting to changing priorities and delivering results under tight deadlines.",
                "department_id" => 2,
                "status" => "open",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "title" => "hr specialist",
                "description" => "Job Responsibilities:
1. Assist in recruitment, onboarding, and employee relations.
2. Maintain and update HR records and documentation.
3. Support payroll processing and benefits administration.
4. Ensure compliance with local labor laws and company policies.
5. Handle employee inquiries and provide HR-related support.
6. Assist in performance management and training initiatives.


*Job Requirements:
1. Bachelor's degree in Human Resources, Business Administration, or a related field.
2. At least 1 year of experience in an HR-related role.
3. Strong communication and interpersonal skills.
4. Familiarity with Egyptian labor laws and HR best practices.
5. Proficiency in Microsoft Office (Word, Excel, PowerPoint).
6. Fluent in English; Arabic is a plus.",
                "department_id" => 1,
                "status" => "open",
                "created_at" => now(),
                "updated_at" => now()
            ],
        ]);
    }
}
