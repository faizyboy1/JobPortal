<?php

use Illuminate\Database\Seeder;
use App\Job;
use Carbon\Carbon;
use App\JobSkill;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = \App\Company::first();
        
        $job = new Job();
        $job->slug = null;
        $job->title = 'Manager- Revenue & Analytics';

        $job->job_description = '<b>Who are we?</b>&nbsp;Froiden is an online platform that is responsible for powering amazing dining experiences for our users daily, both in home and whilst dining out. We started with a vision to ensure that no one ever has a bad meal! Over 10 years froiden has steadily built both a search and discovery platform that fuels stable and growing transaction businesses. Today Froiden has multiple products and services that ensure our users have a great experience whilst improving the food industry.&nbsp;The last 5 years is where most of froiden’s growth has happened, our mission has also evolved to something exponentially greater than being a restaurant reviews and food delivery platform. We are already taking baby steps towards being the biggest farm to table food company in the world.&nbsp;Every month, froiden connects more than 90 million users with 1.3m restaurants globally. froiden continuously aims to serve a bigger purpose of providing better food for all! In order to do this, we need to ensure that users have access to a wide assortment at quality restaurants that are available and accessible.&nbsp;Teams live by this, it’s our bible and we aim to change industry standards based on these four factors – Availability, Assortment, Accessibility and Quality. Users need food, they need variety, they need to access to it and most importantly they need it to be high quality!&nbsp;We are constantly developing a combination of a healthy user ecosystem, great content and an innovative product that makes us a game changer in our field – we are transforming our markets into kitchen-less spaces that give our users a choice of cooking because they want to, not because they have to! As an employee of froiden, you will be helping us build this vision.&nbsp;<span>Please see our blog for more:<a target="_blank" rel="nofollow" href="https://www.froiden.com/blog/10-years">&nbsp;https://www.froiden.com/blog/10-years</a></span><br><b>froiden\'s Momentum</b>&nbsp;<ul><li>froiden annual revenues increased by 45% in FY\'18</li><li>froiden Gold launched in November 2017 and already has 3000+ restaurant partners that serve our ever-increasing subscriber base of more than 400,000 people</li><li>We strive to constantly enhance our technology at a phenomenal pace</li><li>froiden food ordering business has been growing at a considerable rate since inception and currently grows by 2x every 3 months!</li><li>To make sure we match the increasing number of orders with smooth delivery and customer satisfaction, we are supporting this function with a fleet of 50,000+ riders</li></ul>&nbsp;<span>Please see our blog for more:<a target="_blank" rel="nofollow" href="https://www.froiden.com/blog/annual-report-fy18" title="Link: https://www.froiden.com/blog/annual-report-fy18">&nbsp;https://www.froiden.com/blog/annual-report-fy18</a></span>&nbsp;<b>How does this team contribute to froiden?</b>&nbsp;froiden Gold, touted to be the future of dining out, drives ~18% of froiden revenue and on track to be ~35% of froiden by this FY end at current CAGR levels.&nbsp;<ul><li>Current size: 400k members (roughly equivalent of Amazon Prime) and looking to scale to 2M members by end of this FY. Fastest growing membership program currently in India</li><li>Priced at $30 for an annual membership (80% of sales) and $15 for quarterly membership, on track to clock $40M revenue</li><li>Value proposition to consumers: 1+1 on Food, 2+2 on Drinks, valid at all times, across all menu items</li><li>We\'re live in India, UAE and Portugal. Looking to launch Australia, Indonesia, Philippines, Qatar, Lebanon and Turkey this year. Next wave of expansion to cover all 24 froiden countries</li></ul>';

        $job->job_requirement = '<b>Here’s what we’re looking for (Technical Skills):</b>&nbsp;<ul><li>3-5 years of Management Consulting</li><li>Work experience/exposure across multiple markets</li><li>Experience in pricing and market entry assignments</li><li>Attended a leading undergraduate institute in India or US</li><li>Exposure to F&amp;B industry experience would be preferred</li><li>Exposure to or experience in Digital Sales&nbsp;</li></ul><b>Here’s what we’re looking for (Soft Skills):</b>&nbsp;<ul><li>You’re quantitative, strategic, possess high-ownership, structured thinking, and of course are great at excel and PowerPoint</li><li>You also have really high intellectual curiosity and have a fairly global context of businesses and consumers</li></ul><b>Your typical day as a Team will look like</b>&nbsp;Oscillating between driving revenue from all elements of the digital sales channel (SEO, SEM, SMM, GDN) and managing a digital agency to drive desired output across all markets. As froiden Gold launches in new markets, you will also recommend pricing strategy and market entry play.You will also own user acquisition numbers of target vs actuals, analysis of channel efficacy, content efficacy, cracking our online to offline and vice-versa strategy, and help with planning/forecasting growth for next FY.&nbsp;<b>froiden will be providing you with</b>&nbsp;As a Team, you will be immersed in a culture of people who take pride in their company and their ability to change the lives of million of people daily. We place froiden first in our daily tasks with a high level of honesty, ownership and judgment on a foundation of constant and real time feedback.&nbsp;You will be challenged daily to be a better thinker and problem solve using a first principles approach.&nbsp;<span>We promise you, in addition to the quest for 0 bad meals, you will also have an infinite amount of interesting days as a Team – if you have passion and see yourself in our vision go ahead and send in your application!</span>';

        $job->total_positions = '1';
        $job->company_id = $company->id;
        $job->location_id = 2;
        $job->category_id = 3;
        $job->start_date = Carbon::now()->subDays(10);
        $job->end_date = Carbon::now()->addMonth(2);
        $job->status = 'active';

        $job->required_columns = [
            'gender' => false,
            'dob' => false,
            'country' => false
        ];
        $job->meta_details = [
            'title' => $job->title,
            'description' => $job->job_description,
        ];
        $job->section_visibility = [
            'profile_image' => 'yes',
            'resume' => 'yes',
            'cover_letter' => 'yes',
            'terms_and_conditions' => 'yes'
        ];
        $job->save();

        $jobSkill = new JobSkill();
        $jobSkill->skill_id = 4;
        $jobSkill->job_id = $job->id;
        $jobSkill->save();



        $job = new Job();
        $job->slug = null;
        $job->title = 'Data Collection Associate - Casual';

        $job->job_description = '<h3>Job description</h3><div><span>Froiden is a full stack food tech platform focused on restaurant search, discovery and transactions. Across most of our focus countries, we’re the go to food app for all our users. In the last few years Froiden has also steadily built its transaction business on the back of a strong search and discovery business. Today Froiden has multiple products and services that ensure our users have a great meal, every time!<br></span><br>Over the next few years one of our organizational goals is to build an engine that allows our users to have access to an affordable assortment of high quality meals to eat out or order from. We are working towards the idea of a kitchen-less world where-in most people should have access to great and healthy meals at the same price or cheaper than the cost of preparing them at home. We see cooking as something that people should want to do because it’s a joyous activity instead of being a chore.<br>Responsibilities:<ul><li>Collect, curate and update information about restaurants and build a strong product-base for Froiden</li><li>Required to collect comprehensive information&nbsp;including menus and photos&nbsp;by visiting restaurants&nbsp;</li><li>To make sure that all the information a user requires to make a decision about their restaurant preference is available to them</li></ul></div>';

        $job->job_requirement = '<ul><li>0–1 years of work experience</li><li>Must have a valid driver\'s license and car</li><li>Flexible and ideally able to work at least 20 hours per week</li><li>Ability to work in a fast paced environment without compromising on quality</li><li>Intelligent and self-motivated; willing to work hard to achieve and exceed targets</li><li>Eligible to work in Australia</li></ul><br><ul></ul>Note:<span>We will only accept applications from candidates fulfilling all legal requirements to live and work in&nbsp;Australia.&nbsp;</span>';

        $job->total_positions = '1';
        $job->location_id = 1;
        $job->company_id = $company->id;
        $job->category_id = 2;
        $job->start_date = Carbon::now()->subDays(10);
        $job->end_date = Carbon::now()->addMonth(2);
        $job->status = 'active';
        $job->save();

        $jobSkill = new JobSkill();
        $jobSkill->skill_id = 5;
        $jobSkill->job_id = $job->id;
        $jobSkill->save();




        $job = new Job();
        $job->slug = null;
        $job->title = 'Data Collection Associate - Casual';

        $job->job_description = "We're looking for seasoned DevOps &amp; Infrastructure engineers to join our high-caliber team to help us architect and maintain scalable systems which can handle millions of daily active users. We handle everything from data storage, to synchronisation and coordination of large server clusters, to providing a runtime environment for front end code. We are looking for candidates who share a passion for tackling complexity and building platforms that can scale through multiple orders of magnitude. We are focused on solving the hardest, most interesting challenges of developing software at scale without sacrificing stability, quality, velocity, or code health.&nbsp;Here's what you'll do everyday:<ul><li>Design and build scalable, failure tolerant server architecture</li><li>Managing multi-server MySQL, Redis and Cassandra clusters with failover and load balancing</li><li>Create auto scaling systems that optimize performance and cost</li><li>Setup continuous delivery for multiple platforms in production and staging environments</li><li>Troubleshooting and resolving issues related to web services and mobile applications development &amp; deployment</li><li>Leveraging current and cutting edge technologies while testing bleeding edge technologies for future use</li><li>Create tools and processes to improve engineering team efficiency</li><li>Process automation and re-engineering</li><li>Perform regularly scheduled maintenance to ensure the operational health of the environment</li></ul>&nbsp;You'll also get:<ul><li>To work in our state of the art office with Macbooks, a big screen for debugging, designing or whatever you're into, and high speed internet</li><li>Open workspaces where the glass walls bear the finest ideas and cryptic musings (quite literally)</li><li>A cup of coffee (or many) while your code compiles at our own cafeteria which also serves breakfast, lunch, and dinner</li></ul>";

        $job->job_requirement = "Here's what we're looking for:<ul><li>At least 2 years of experience working in a DevOps / SRE role.</li><li>Solid understanding and experience working with high availability, high performance, multi-data center systems</li><li>Implementing zero-downtime deployments in a load balanced multi-server environment and being responsive to off-hour emergencies and activities</li><li>Experience working with infrastructure as code tools like Ansible / Chef / Puppet</li><li>Experience working on MySQL, Solr, Cassandra, Memcache and PHP / Java / Golang</li><li>A strong background in Linux/Unix administration</li><li>Ability to use a wide variety of open source technologies and cloud services (experience with AWS eco-system would be a plus)</li><li>Practical knowledge of shell scripting and at least one scripting language (Python, Ruby, Perl)</li><li>Knowledge of IP networking, VPNs, DNS, load balancing and firewalling</li><li>Familiar with implementing Continuous Integration, Delivery and Deployment practices</li><li>Strong Computer Science fundamentals (Networking, Databases, Operating Systems)</li><li>Understanding of Service Oriented Architectures, Micro Services and Distributed Systems</li></ul>";

        $job->total_positions = '1';
        $job->location_id = 3;
        $job->company_id = $company->id;
        $job->category_id = 1;
        $job->start_date = Carbon::now()->subDays(10);
        $job->end_date = Carbon::now()->addMonth(2);
        $job->status = 'active';
        $job->save();

        $jobSkill = new JobSkill();
        $jobSkill->skill_id = 1;
        $jobSkill->job_id = $job->id;
        $jobSkill->company_id = $company->id;
        $jobSkill->save();

        $jobSkill = new JobSkill();
        $jobSkill->skill_id = 2;
        $jobSkill->job_id = $job->id;
        $jobSkill->company_id = $company->id;
        $jobSkill->save();

        $jobSkill = new JobSkill();
        $jobSkill->skill_id = 3;
        $jobSkill->job_id = $job->id;
        $jobSkill->company_id = $company->id;
        $jobSkill->save();

    }
}
