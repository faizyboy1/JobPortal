@extends('layouts.app')

@push('head-script')
<style>
    .list-group-item{
        background-color: #f6f7fb;
        margin: 5px;
        border-radius: 0 !important;
        border: 0;
        padding: 5px;
        padding-left: 30px;
    }

    .list-group-item p {
        font-size: 12px;
        padding-left: 20px;
    }

    .list-group-item .btn{
        font-size: 13px;
        display: inline-block;
        padding: 0 5px;
        color: var(--main-color);
    }
</style>
    
@endpush
@section('content')    
@php
    $countries_list=get_countries_list();
@endphp    
<div class="container">
        <div class="form__card">
            <form action="{{ route('candidate.file') }}" enctype="multipart/form-data"
            method="POST">
            @csrf
                <input type="file" name="file">
                <button type="submit" id="uploadResume" class=" submit button1 ">Upload Resume</button>
            </form>
        <form id="submit-form" class="form" method="post" enctype="multipart/form-data"
        {{-- action="{{url('candidate/resume')}}" --}}
        >
            <div style="position: relative; padding:1.5rem " class="box-container">
                @csrf
                <div>
                    @if (count($errors)>0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error )
                                    <li>{{ $error }}</li>
                                @endforeach
                            <ul/>
                        </div>
                    @endif
                </div>
                <div class="box">
                    <h1 style="text-align: center">Profile</h1>
                    <div style="display: flex; justify-content:space-between; ">
                        <div class="form__group">
                            
                            <input type="text" id="first_name"  
                            class="form_group-input" 
                            placeholder="First Name*"
                            name="first_name"
                            value={{ $name ? explode(" ",$name)[0]:"" }}
                            >
                            <label for="first" class="form_group-label">
                                First Name<span style="color: red">*</span>
                            </label>
                        </div>
                       
                        <div class="form__group">
                            
                            <input type="text" id="middle"  
                            class="form_group-input" 
                            placeholder="Middle Name"
                            name="middle_name"
                            value={{ (count(explode(" ",$name))-1>2) ?(explode(" ",$name)[1]):"" }}
                            >
                            <label for="middle" class="form_group-label">
                                Middle Name
                            </label>
                        </div>
                        
                        <div class="form__group">
                            
                            <input type="text" id="last_name"  
                            class="form_group-input" 
                            placeholder="Last Name*"
                            name="last_name"
                            value={{$name && (count(explode(" ",$name))-1<2)  ? (explode(" ",$name)[1]) : (explode(" ",$name)[2]) }}
                            >
                            <label for="last" class="form_group-label">
                                Last Name<span style="color: red">*</span>
                            </label>
                        </div>

                    </div>
                    <div style="display: flex; justify-content:space-between; ">
                        <div class="form__group">
                            <input type="text" id="address"  
                            class="form_group-input" 
                            placeholder="Address"
                            name="address"
                            value={{ $address[0]  }}
                            >
                            <label for="address" class="form_group-label">
                                Address
                            </label>
                        </div>
                        <div class="form__group">
                            
                            <input type="text" id="state"  
                            class="form_group-input" 
                            placeholder="State"
                            name="state"
                            >
                            <label for="state" class="form_group-label">
                                State
                            </label>
                        </div>
                        <div class="form__group">
                            
                            <input type="text" id="city"  
                            class="form_group-input" 
                            placeholder="City"
                            name="city"
                            >
                            <label for="city" class="form_group-label">
                                City
                            </label>
                        </div>
                        
                        

                    </div>
                    @dd($address)
                    @dd($countries_list)
                    <div style="display: flex; justify-content:space-between; ">
                        <div class="form__group">
                            <select style="padding:10px" class="form_group-input" name="country_name" id="country">
                                <option selected disabled>-- Select Country --</option>
                                @foreach ($countries_list as $key=>$country)
                                    <option value="{{ $country['name'] }}"
                                    data-index="{{ $key }}"
                                        >
                                        {{ $country['name'] }}
                                    </option>
                                @endforeach
                            </select>   
                            {{-- <input type="text" id="country"  
                            class="form_group-input" 
                            placeholder="Country*"
                            name="country"
                            > --}}
                            <label for="country" class="form_group-label">
                                Country<span style="color: red">*</span>
                            </label>
                        </div>
                        <div class="form__group">
                            
                            <input type="text" id="zipcode"  
                            class="form_group-input" 
                            placeholder="Zip-Code"
                            name="zip_code"
                            >
                            <label for="zipcode" class="form_group-label">
                                Zip-Code
                            </label>
                        </div>
                    </div>
                    <div style="display: flex; justify-content:space-between; ">
                        <div class="form__group">
                            <input type="text" id="code"  
                            class="form_group-input" 
                            placeholder="Country Code e.x +92*"
                            name="country_code"
                            >
                            <label for="code" class="form_group-label">
                                Country Code<span style="color: red">*</span>
                            </label>
                        </div>
                        <div class="form__group">
                            
                            <input type="number" id="phone" 
                            class="form_group-input" 
                            placeholder="Phone Number"
                            name="phone_number"
                            >
                            <label for="phone" class="form_group-label">
                                Phone Number<span style="color: red">*</span>
                            </label>
                        </div>
                    </div>
                    <div class="form__group">
                        
                            <input type="email" id="email"  
                            class="form_group-input" 
                            placeholder="Email*"
                            name="email"
                            >
                            <label for="email" class="form_group-label">
                                Email<span style="color: red">*</span>
                            </label>
                    </div>
                    <div class="form__group">
                        <input type="file" name="profile_picture" id="profile_picture">
                    </div>
                   
                </div>
                <div class="box2">
                    <h1 style="text-align: center">Objective</h1>
                        <div class="form__group">
                            
                            <textarea type="text" id="first"  
                            class="form_group-input" 
                            placeholder="Objective"
                            name="objective"
                            ></textarea>
                            {{-- <label for="first" class="form_group-label">
                                First Name
                            </label> --}}
                    </div>
    
                </div>
                <div class="box3" id="#box3">
                    <h1 style="text-align: center">Education</h1>
                    <div id="education_fields">
                        <div class="d-flex justify-content-between">
                                <div class="form__group">
                            
                                    <input  type="text"
                                     id="degree_name" 
                                     name="degree_name[]" 
                                    class="form_group-input" 
                                    placeholder="Degree">
                                    <label for="degree_name" class="form_group-label" >
                                        Degree
                                    </label>
                                </div>          
                                <div class="form__group">
                                
                                    <input  type="number" id="passing_year[]" name="passing_year[]"  
                                    class="form_group-input"
                                    placeholder="Year">
                                    <label for="passing_year"  class="form_group-label">
                                        Enter The Passing Year
                                    </label>
                                </div>          
                                <div class="form__group">
                                
                                    <input type="text" id="institute[]" name="institute[]"  
                                    class="form_group-input"
                                    placeholder="University/School">
                                    <label for="institute" class="form_group-label">
                                        University/School
                                    </label>
                                </div>
                            <div class="input-group-append " style="padding: 1rem 0">
                                <button class="btn btn-success"
                                style="padding:  0 2rem;
                                background-color: #1579d0;
                                color: #fff;
                                border-color:#1579d0;
                                box-shadow: 0 1px 1px rgb(0 0 0 / 8%);"
                                 type="button" id="add-more">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>          
                            
                        </div>
                       
                    </div>
                    
                    
                </div>
                <div class="box4">
                    <h1 style="text-align: center">Certifications</h1>
                    <div id="certificate_fields">
                        <div class="d-flex justify-content-between">
                            <div class="form__group">
                            
                                <input  type="text" id="certification_name" name="certification_name[]"  
                                class="form_group-input" 
                                placeholder="Name">
                                <label for="first" class="form_group-label" >
                                    Degree
                                </label>
                            </div>          
                            <div class="form__group">
                            
                                <input  type="number" id="year" name="certification_year[]"  
                                class="form_group-input" 
                                placeholder="Year">
                                <label for="year"  class="form_group-label">
                                    Enter The Passing Year
                                </label>
                            </div>          
                            <div class="form__group">
                            
                                <input type="text" id="University/School" name="certification_institute[]"  
                                class="form_group-input" 
                                placeholder="University/School">
                                <label for="University/School" class="form_group-label">
                                    University/School
                                </label>
                            </div>
                            <div class="input-group-append " style="padding: 1rem 0">
                                <button class="btn btn-success"
                                style="padding:  0 2rem;
                                background-color: #1579d0;
                                color: #fff;
                                border-color:#1579d0;
                                box-shadow: 0 1px 1px rgb(0 0 0 / 8%);"
                                 type="button" id="add-more-certifications">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>          
                            
                        </div>
                    </div>
                </div>    
                <div class="box5">
                    <h1 style="text-align: center">Honors & Awards</h1>
                    <div id="awards_fields">
                        <div class="d-flex justify-content-between">
                            <div class="form__group">
                            
                                <input  type="text" id="award_name" name="award_name[]"  
                                class="form_group-input" 
                                placeholder="Degree">
                                <label for="award_name" class="form_group-label" >
                                    Award
                                </label>
                            </div>          
                            <div class="form__group">
                            
                                <input  type="number" id="year" name="award_year[]"  
                                class="form_group-input" 
                                placeholder="Year">
                                <label for="year"  class="form_group-label">
                                    Enter The Receving Year
                                </label>
                            </div>          
                            <div class="form__group">
                            
                                <input type="text" id="University/School" name="award_institute[]"  
                                class="form_group-input" 
                                placeholder="University/School">
                                <label for="University/School" class="form_group-label">
                                    University/School
                                </label>
                            </div>
                            <div class="input-group-append " style="padding: 1rem 0">
                                <button class="btn btn-success" 
                                style="padding:  0 2rem;
                                background-color: #1579d0;
                                color: #fff;
                                border-color:#1579d0;
                                box-shadow: 0 1px 1px rgb(0 0 0 / 8%);"
                                 type="button" id="add-more-awards">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>          
                            
                        </div>
                    </div>
                </div>
                <div class="box6">
                    <h1 style="text-align: center">Languages</h1>
                    <div id="language_fields">
                        <div class="d-flex justify-content-between">
                            <div class="form__group">
                                <input type="text" id="language" name="language[]"  
                                class="form_group-input" 
                                placeholder="Language">
                                <label for="language" class="form_group-label">
                                    Language
                                </label>
                            </div>
                            <div class="input-group-append " style="padding: 1rem 0">
                                <button class="btn btn-success"
                                style="padding:  0 2rem;
                                background-color: #1579d0;
                                color: #fff;
                                border-color:#1579d0;
                                box-shadow: 0 1px 1px rgb(0 0 0 / 8%);"
                                 type="button" id="add-more-language">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>          
                            
                        </div>
                    </div>
                </div>
                <div class="box7">
                    <h1 style="text-align: center">Skills</h1>
                    <div id="skill_fields">
                        <div class="d-flex justify-content-between">
                            <div class="form__group">
                                <input type="text" id="skills" name="skills[]"  
                                class="form_group-input" 
                                placeholder="Skills">
                                <label for="skills" class="form_group-label">
                                    Skills
                                </label>
                            </div>
                            <div class="input-group-append " style="padding: 1rem 0">
                                <button class="btn btn-success"
                                style="padding:  0 2rem;
                                background-color: #1579d0;
                                color: #fff;
                                border-color:#1579d0;
                                box-shadow: 0 1px 1px rgb(0 0 0 / 8%);"
                                 type="button" id="add-more-skill">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>          
                            
                        </div>
                    </div>
                </div>
                <div class="box8">
                    <h1 style="text-align: center">Work Experience</h1>
                    <div id="experience_fields">
                        <div>
                            <div class="d-flex justify-content-between">
                                <div class="form__group">
                                
                                    <input  type="text" id="company_name" name="company_name[]"  
                                    class="form_group-input" 
                                    placeholder="Company Name">
                                    <label for="company_name" class="form_group-label" >
                                        Company Name
                                    </label>
                                </div>          
                                <div class="form__group">
                                
                                    <input  type="date" id="start_date" name="start_date[]"  
                                    class="form_group-input" 
                                    placeholder="Starting Date">
                                    <label for="start_date" class="form_group-label" >
                                        Starting Date
                                    </label>
                                </div>          
                                <div class="form__group">
                                    <input type="hidden" name="end_date[0]" value="null" >
                                    <input  type="date" id="end_date0" name="end_date[0]"  
                                    class="form_group-input" 
                                    placeholder="Ending Date">
                                    <label for="end_date0" class="form_group-label" >
                                        Ending Date
                                    </label>
                                    
                                </div>
                                <div class="form__group">
                                    <input type="hidden" name="present[0]" value="null" >
                                    <input  type="checkbox" id="present0" name="present[0]" onclick="disableCheck(0)" >
                                    <label for="present0">Present</label>    
                                </div>          
                                          
                                
                            </div>
                            <div class="form__group">
                                
                                <input  type="text" id="job_title" name="job_title[]"  
                                class="form_group-input" 
                                placeholder="Job Tittle">
                                <label for="job_title"  class="form_group-label">
                                    Job Tittle
                                </label>
                            </div>          
                            <div class="form__group">
                            
                                <textarea type="text" id="job_description" name="job_description[]"  
                                class="form_group-input" 
                                placeholder="Job Description"></textarea>
                                {{-- <label for="University/School" class="form_group-label">
                                    University/School
                                </label> --}}
                            </div>
                            <div class="input-group-append " style="padding: 1rem 0; margin-left: 1rem; ">
                                <button class="btn btn-success"
                                style="padding:  1rem 7rem;
                                background-color: #1579d0;
                                color: #fff;
                                font-size:2rem;
                                border-color:#1579d0;
                                box-shadow: 0 1px 1px rgb(0 0 0 / 8%);"
                                type="button" id="add-more-experience">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            {{--  --}}
                        </div>
                        
                    </div>
                </div>
                <span style="color: red;position: absolute;bottom:0; left:25px; " id="education_fields_error"></span>
            </div>
        </form>
    </div>
	
</div>
<hr>
<div style="display: flex; justify-content: space-between">
    <button disabled type="button" id="previous" class="previous button1">Previous</button>
    <button type="button" id="next" class=" next button1">Next</button>
    <button type="submit" id="submit" class=" submit button1 ">Submit</button>

</div>
<div style="display: flex; justify-content:flex-end ;padding-bottom: 2rem;">
</div>

    
<style>
    .box-container{
        display: flex;
    }
    .box{
        width: 100%;
        overflow: hidden;
        /* background-color: orangered; */
    }
    /* Add padding and border to inner content
    for better animation effect */
    .box2,
    .box3,
    .box4,
    .box5,
    .box6,
    .box7,
    .box8{
        display: none;
        width: 100%;
        overflow: hidden;
    }

/* Button k styles */
@keyframes moveInbtn{
	0%{
		opacity: 0;
		transform: translateY(30px);
	
	}
	100%{
	opacity: 1;
	transform: translate(0px);
	}

}
.button1,
.button1:link,
.button1:visited{
    height: 40px;
    width: 100px;
	display: inline-block;
	background-color: #1579d0;
	text-transform: uppercase;
	text-decoration: none;
    text-align: center;
	color:#fff ;
	padding: 10px; 
	position: relative;
	top:50%;
	left: 0%; 
	border-radius: 100px;
	transition: all 0.4s;
    border: none;
	animation: moveInbtn  .5s ease-out .75s  backwards ;
}
.button1:hover{
    cursor: pointer;
	transform: translateY(-3px);
	box-shadow: 0 20px 10px rgba(0,0,0,0.2);
}
.button1:active{
	transform: translateY(-1px);
	box-shadow: 0 10px 5px rgba(0,0,0,0.2);
    border: none;
}

.button1::after{
	content:"";
	display: inline-block;
	position: absolute;
	height: 100%;
	width:100%;
	top: 0;
	left: 0;
	background-color: #1579d0;
	border-radius: 100px;
	z-index: -1;
	transition: all .4s;
}
.button1:hover::after{
	transform: scale(2);
	opacity: 0;
}
.button1:disabled:hover{
    transform: none;
    box-shadow: none;
    cursor: none;
}
.button1:focus{
    outline: none;
}

/* Button k styles */


    /* Form ke sari styling */


    html{
	font-size: 10px;
}
.form__section{
	padding: 15rem;
	background-color: gold;

}
.form__card{
	width: 100%;
	border-radius: .3rem;
	margin: 0 auto;
	background-color: white;
	padding: 5rem;
	
}
.form{
	width: 100%;
	display: block;
}
.form__group{
    width: 100%;
	padding: 2rem;
	position: relative;
}
.form_group-input{
    width: 100%;
	border:none;
	background-color: #eee;
	padding: 1rem;
	border-radius: .3rem;
	border-bottom: 3px solid transparent;
}
.form_group-input::-webkit-input-placeholder{
	font-weight: 100;
	color: #000000;
}
.form_group-input:focus{
	outline: none;
	border-bottom: 3px solid #1579d0;
	transition: all .3s;
}
.form_group-input:focus:invalid{
	border-bottom: 3px solid red;
}
.form_group-label{
	position: absolute;
	top: 6.5rem;
	left: 3rem;
	font-weight: 700;
	font-size: 1.3rem;
	transition: all .3s; 
	font-family: sans-serif;
	display: block;
}
.form_group-input:placeholder-shown + .form_group-label{
	opacity: 0;
	visibility: hidden;
	transform: translateY(-3rem);
}
.form__group-radio{
	display: inline-block;
	font-size: 1.3rem;
	

}
.radio__btn{
	height: 3rem;
	width: 3rem;
	display: inline-block;
	border-radius: 50%;
	border: 2px solid gold;
	position: relative;
	margin: 0 2rem;
	top: 1.2rem; 
	
}
.radio__btn::after{
	content: "";
	height: 1.5rem;
	width: 1.5rem;
	background-color: gold;
	border-radius: 50%;
	position: absolute;
	display: block;
	top: 50%;
	left: 50%;
	transform: translate(-50%,-50%);
	opacity: 0;
	transition: opacity .2s;
}
.form_group-radio--btn:checked ~ .form_group-radio--label .radio__btn::after{
	opacity: 1
}
.form_group-radio--btn
{
	display: none;
}




</style>
{{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}"
            type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}"
            type="text/javascript"></script> --}}
    <script src="{{url('https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js')}}"></script>
    <script type="text/javascript">

        var countries_list = <?=json_encode($countries_list); ?>;
        console.log(countries_list);
    
        $('#country').on('change',function(){
            let key_selected = $( "#country option:selected").data('index');
            console.log(key_selected);
            Object.entries(countries_list).forEach(([key, value]) => {
                if(key_selected == key)
                {
                    $('#code').val('+'+value.code);
                }
            });
        });
    
    </script>
<script>
   
       
    $(document).ready(function(){
        

    $("#submit").hide()
        let stack=0;
        let check=null;
        
        $(".previous").click(function(){
            // document.getElementById("previous").style.display = 'none';
            stack--;
            if(stack == 0){
            document.getElementById("previous").disabled = false;
            $(".box").css({'transform':'translateX(0%)',
            'display':'block'});
            $(".box2").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box3").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box4").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box5").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box6").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box7").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box8").css({'transform':'translateX(150%)',
            'display':'none'});
        }
        
        if(stack == 1){
            document.getElementById("previous").disabled = false;
            $(".box").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box2").css({'transform':'translateX(0%)',
            'display':'block'});
            $(".box3").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box4").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box5").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box6").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box7").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box8").css({'transform':'translateX(150%)',
            'display':"none"});
        }
        if(stack == 2){
            document.getElementById("previous").disabled = false;
            $(".box").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box2").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box3").css({'transform':'translateX(0%)',
            'display':'block'});
            $(".box4").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box5").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box6").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box7").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box8").css({'transform':'translateX(150%)',
            'display':"none"});
            $('#education_fields_error').html("")

        }
        if(stack == 3){
            document.getElementById("previous").disabled = false;
            $(".box").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box2").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box3").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box4").css({'transform':'translateX(0%)',
            'display':'block'});
            $(".box5").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box6").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box7").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box8").css({'transform':'translateX(150%)',
            'display':"none"});

        }
        if(stack == 4){
            $(".box").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box2").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box3").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box4").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box5").css({'transform':'translateX(0%)',
            'display':'block'});
            $(".box6").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box7").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box8").css({'transform':'translateX(150%)',
            'display':"none"});

        }
        if(stack == 5){
            $(".box").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box2").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box3").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box4").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box5").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box6").css({'transform':'translateX(0%)',
            'display':'block'});
            $(".box7").css({'transform':'translateX(150%)',
            'display':'none'});
            $(".box8").css({'transform':'translateX(150%)',
            'display':"none"});

        }
        if(stack == 6){
            document.getElementById("next").disabled = false;
            $("#next").show()
            $("#submit").hide() 
            $(".box").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box2").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box3").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box4").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box5").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box6").css({'transform':'translateX(-150%%)',
            'display':'none'});
            $(".box7").css({'transform':'translateX(0%)',
            'display':'block'});
            $(".box8").css({'transform':'translateX(150%)',
            'display':"none"});

        }
            console.log(stack)
           
        });
        $(".next").click(function(){
console.log("hh")
                stack++;
        if(stack == 1){
            document.getElementById("previous").disabled = false;
            let first_name=$("#first_name").val();
            let last_name=$("#last_name").val();
            // let address=$("#address").val();
            // let city=$("#city").val();
            // let state=$("#state").val();
            let country=$("#country").val();
            // let zipcode=$("#zipcode").val();
            let code=$("#code").val();
            let phone=$("#phone").val();
            let email=$("#email").val();
            if((first_name.length  < 1) || (last_name.length  < 1) || (country.length < 1)  || (email.length < 1 )){
                check=false;
                stack=0;
                // $('#education_fields_error').html("Please Complete the required fields correctly")
                console.log("Malik");
            }
            else{
                stack=1;
                check=true;
            }
            if(!check){
                $('#education_fields_error').html("Please Complete the fields correctly")
            }
            if(stack == 1){

            $(".box").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box2").css({'transform':'translateX(0%)',
            'display':"block"});
            $(".box3").css({'transform':'translateX(150%)',
            'display':"none"});
            $(".box4").css({'transform':'translateX(150%)',
            'display':"none"});
            $(".box5").css({'transform':'translateX(150%)',
            'display':"none"});
            $(".box6").css({'transform':'translateX(150%)',
            'display':"none"});
            $(".box7").css({'transform':'translateX(150%)',
            'display':"none"});
            $(".box8").css({'transform':'translateX(150%)',
            'display':"none"});
        }
            }
        if(stack == 2){
           
                $(".box").css({'transform':'translateX(-150%)',
            'display':'none'});
            $(".box2").css({'transform':'translateX(-150%)',
            'display':"none"});
            $(".box3").css({'transform':'translateX(0%)',
            'display':"block"});
        }
        if(stack === 3){
            let degree_name =$("input[name='degree_name[]']").map(function(){return $(this).val();}).get() ;
            let passing_year =$("input[name='passing_year[]']").map(function(){return $(this).val()}).get();
            let institute=$("input[name='institute[]']").map(function(){return $(this).val()}).get();
            
            // $('#degree_append').remove()
            console.log(degree_name.length , degree_name[0].length);
            for(let i=0; i < degree_name.length; i++){
                if( (degree_name[i].length < 2 )||
                  (passing_year[i].length < 4  )||
                   (institute[i].length < 2 ) ) {
                    check=false;
                    stack = 2;
                }
                else {
                    check=true;
                    stack = 3;
                }
            }
            
               
            if(!check){
                $('#education_fields_error').html("Please Complete the fields correctly")
            }   
            if(stack === 3) {
                $(".box3").css({'transform':'translateX(-150%)',
            'display':"none"});
            $(".box4").css({'transform':'translateX(0%)',
            'display':"block"});
            }
        }
        if(stack == 4){
            $(".box4").css({'transform':'translateX(-150%)',
            'display':"none"});
            $(".box5").css({'transform':'translateX(0%)',
            'display':"block"});
            
        }
        if(stack == 5){

            $(".box5").css({'transform':'translateX(-150%)',
            'display':"none"});
            $(".box6").css({'transform':'translateX(0%)',
            'display':"block"});
            
        }
        if(stack == 6){
            let language =$("input[name='language[]']").map(function(){return $(this).val();}).get() ;
            for(let i=0; i<language.length; i++){
                if(language[i].length < 3){
                    stack = 5;
                    check=false
                }
                else{
                    check=true;
                }
            }
            if(!check){
                $('#education_fields_error').html("Please Complete the fields correctly")
            }  
            if(stack === 6){
                
            $(".box6").css({'transform':'translateX(-150%)',
            'display':"none"});
            $(".box7").css({'transform':'translateX(0%)',
            'display':"block"});
            }
            
        }
        
        if(stack == 7){
            // document.getElementById("next").style.display = 'none';
            let skills =$("input[name='skills[]']").map(function(){return $(this).val();}).get() ;
            for(let i=0; i<skills.length; i++){
                if(skills[i].length < 1){
                    stack = 6;
                    check=false
                }
                else{
                    check=true;
                }
            }
            if(!check){
                $('#education_fields_error').html("Please Complete the fields correctly")
            } 
            if(stack === 7){

            $("#next").hide()
            $("#submit").show() 
            $(".box7").css({'transform':'translateX(-150%)',
            'display':"none"});
            $(".box8").css({'transform':'translateX(0%)',
            'display':"block"});
            
            }
        }
        if(check){
                $('#education_fields_error').html("")
            }
            console.log(stack)
          
        });

    });
    //  to add additional field
    // For select 2
    $(".select2").select2();

var room = 1;
var room_certificate = 1;
var room_awards = 1;
var room_language = 1;
var room_skill = 1;
var room_experience = 0;
$('#add-more').click(function () {
    room++;
    
    var divtest = `
    <div class="d-flex justify-content-between removeclass${room}">
                            <div class="form__group">
                            
                                <input  type="text" id="first" name="degree_name[]" required="" 
                                class="form_group-input" 
                                placeholder="Degree">
                                <label for="first" class="form_group-label" >
                                    Degree
                                </label>
                            </div>          
                            <div class="form__group">
                            
                                <input  type="number" id="year" name="passing_year[]" required="" 
                                class="form_group-input" 
                                placeholder="Year">
                                <label for="year"  class="form_group-label">
                                    Enter The Passing Year
                                </label>
                            </div>          
                            <div class="form__group">
                            
                                <input type="text" id="institute" name="institute[]" required="" 
                                class="form_group-input" 
                                placeholder="Institute">
                                <label for="institute" class="form_group-label">
                                    University/School
                                </label>
                            </div>
                            <div class="input-group-append" style="padding: 1rem 0" > 
                        	<button class="btn btn-danger" style="padding: 0 2rem;" type="button" onclick="remove_education_fields(${room});">
                            		<i class="fa fa-minus"></i>
                        	</button>
                    	    </div>        
                            
                        </div>`;

    $('#education_fields').append(divtest);
    $(`.removeclass${room} input`).focus();
})

function remove_education_fields(rid) {
    $('.removeclass' + rid).remove();
}


$('#add-more-certifications').click(function () {
    room_certificate++;

    var divtest = `
    <div class="d-flex justify-content-between removeclassCertificate${room_certificate}">
                            <div class="form__group">
                            
                                <input  type="text" id="certification_name" name="certification_name[]" required="" 
                                class="form_group-input" 
                                placeholder="Name">
                                <label for="certification_name" class="form_group-label" >
                                    Degree
                                </label>
                            </div>          
                            <div class="form__group">
                            
                                <input  type="number" id="year" name="certification_year[]" required="" 
                                class="form_group-input" 
                                placeholder="Year">
                                <label for="year"  class="form_group-label">
                                    Enter The Passing Year
                                </label>
                            </div>          
                            <div class="form__group">
                            
                                <input type="text" id="University/School" name="certification_institute[]" required="" 
                                class="form_group-input" 
                                placeholder="University/School">
                                <label for="University/School" class="form_group-label">
                                    University/School
                                </label>
                            </div>
                            <div class="input-group-append" style="padding: 1rem 0" > 
                        	<button class="btn btn-danger" style="padding: 0 2rem;" type="button" onclick="remove_certificate_fields(${room_certificate});">
                            		<i class="fa fa-minus"></i>
                        	</button>
                    	    </div>        
                            
                        </div>`;

    $('#certificate_fields').append(divtest);
    $(`.removeclassCertificate${room_certificate} input`).focus();
})
function remove_certificate_fields(rid) {
    $('.removeclassCertificate' + rid).remove();
}

$('#add-more-awards').click(function () {
    room_awards++;
    

    var divtest = `
    <div class="d-flex justify-content-between removeclassAwards${room_awards}">
                            <div class="form__group">
                            
                                <input  type="text" id="award" name="award_name[]" required="" 
                                class="form_group-input" 
                                placeholder="Degree">
                                <label for="award" class="form_group-label" >
                                    Award
                                </label>
                            </div>          
                            <div class="form__group">
                            
                                <input  type="number" id="year" name="award_year[]" required="" 
                                class="form_group-input" 
                                placeholder="Year">
                                <label for="year"  class="form_group-label">
                                    Enter The Receving Year
                                </label>
                            </div>          
                            <div class="form__group">
                            
                                <input type="text" id="University/School" name="award_institute[]" required="" 
                                class="form_group-input" 
                                placeholder="University/School">
                                <label for="University/School" class="form_group-label">
                                    University/School
                                </label>
                            </div>
                            <div class="input-group-append" style="padding: 1rem 0" > 
                        	<button class="btn btn-danger" style="padding: 0 2rem;" type="button" onclick="remove_awards_fields(${room_awards});">
                            		<i class="fa fa-minus"></i>
                        	</button>
                    	    </div>        
                            
                        </div>`;

    $('#awards_fields').append(divtest);
    $(`.removeclassAwards${room_awards} input`).focus();
})

function remove_awards_fields(rid) {
    $('.removeclassAwards' + rid).remove();
}
$('#add-more-language').click(function () {
    room_language++;
    

    var divtest = `
    <div class="d-flex justify-content-between removeclassLanguage${room_language}">
                                     
                            <div class="form__group">
                            
                                <input type="text" id="language" name="language[]" required="" 
                                class="form_group-input" 
                                placeholder="Language">
                                <label for="language" class="form_group-label">
                                    Language
                                </label>
                            </div>
                            <div class="input-group-append" style="padding: 1rem 0" > 
                        	<button class="btn btn-danger" style="padding: 0 2rem;" type="button" onclick="remove_language_fields(${room_language});">
                            		<i class="fa fa-minus"></i>
                        	</button>
                    	    </div>        
                            
                        </div>`;

    $('#language_fields').append(divtest);
    $(`.removeclassLanguage${room_language} input`).focus();
})

function remove_language_fields(rid) {
    $('.removeclassLanguage' + rid).remove();
}


//Skills Add/Subtract Button
$('#add-more-skill').click(function () {
    room_skill++;
    

    var divtest = `
    <div class="d-flex justify-content-between removeclassSkill${room_skill}">
                                     
                            <div class="form__group">
                            
                                <input type="text" id="skill" name="skills[]" required="" 
                                class="form_group-input" 
                                placeholder="Skill">
                                <label for="skill" class="form_group-label">
                                    Skill
                                </label>
                            </div>
                            <div class="input-group-append" style="padding: 1rem 0" > 
                        	<button class="btn btn-danger" style="padding: 0 2rem;" type="button" onclick="remove_skill_fields(${room_skill});">
                            		<i class="fa fa-minus"></i>
                        	</button>
                    	    </div>        
                            
                        </div>`;

    $('#skill_fields').append(divtest);
    $(`.removeclassSkill${room_skill} input`).focus();
})

function remove_skill_fields(rid) {
    $('.removeclassSkill' + rid).remove();
}

//Work Experience
$('#add-more-experience').click(function () {
    room_experience++;
    

    var divtest = `
    <div class="removeclassExperience${room_experience}">
        <div class="d-flex justify-content-between ">
            <div class="form__group ">
                                
                <input  type="text" id="company_name" name="company_name[]" required="" 
                class="form_group-input" 
                placeholder="Company Name">
                <label for="company_name" class="form_group-label" >
                    Company Name
                </label>
            </div>          
            <div class="form__group">
            
                <input  type="date" id="start_date" name="start_date[]" required="" 
                class="form_group-input" 
                placeholder="Starting Date">
                <label for="start_date" class="form_group-label" >
                    Starting Date
                </label>
            </div>          
            <div class="form__group">
                <input type="hidden" name="end_date[${room_experience}]" value="null" >
                <input  type="date" id="end_date${room_experience}" name="end_date[${room_experience}]"  
                class="form_group-input" 
                placeholder="Ending Date">
                <label for="end_date${room_experience}" class="form_group-label" >
                    Ending Date
                </label>

            </div>
            <div class="form__group">
                <input type="hidden" name="present[${room_experience}]" value="null" >
                <input  type="checkbox" id="present${room_experience}" name="present[${room_experience}]" onclick="disableCheck(${room_experience})" >
                <label for="present${room_experience}">Present</label>    
                </div>
            
        </div>
        <div class="form__group">
                            
            <input  type="text" id="job_title" name="job_title[]" required="" 
            class="form_group-input" 
            placeholder="Job Tittle">
            <label for="job_title"  class="form_group-label">
                Job Tittle
            </label>
        </div>          
        <div class="form__group">
        
            <textarea type="text" id="job_description" name="job_description[]" required="" 
            class="form_group-input" 
            placeholder="Job Description"></textarea>
            {{-- <label for="University/School" class="form_group-label">
                University/School
            </label> --}}
        </div>
        <div class="input-group-append" style="padding: 1rem 0; margin-left: 1rem;" > 
            <button class="btn btn-danger" style="padding:  1.5rem 7rem" type="button" onclick="remove_experience_fields(${room_experience});">
                    <i class="fa fa-minus"></i>
            </button>
        </div> 
    </div>
    `;

    $('#experience_fields').append(divtest);
    $(`.removeclassExperience${room_experience} input`).focus();
})

function remove_experience_fields(rid) {
    $('.removeclassExperience' + rid).remove();
}
function disableCheck(id) {
    if ($(`#present${id}`).is(":checked"))
{
    $(`#end_date${id}`).prop("disabled",true);
    $(`#end_date${id}`).val("");
}
if ($(`#present${id}`).is(":checked") == false){
    $(`#end_date${id}`).prop("disabled",false);

}

console.log($(`#end_date${id}`).val())
}

$('#save-form').click(function () {
    $.easyAjax({
        url: '{{route('admin.locations.store')}}',
        container: '#createForm',
        type: "POST",
        redirect: true,
        data: $('#createForm').serialize()
    })
});
</script>
@endsection





@push('footer-script')
    <script src="{{ asset('assets/plugins/jQueryUI/jquery-ui.min.js') }}"></script>

    <script>
        var updated = true;

        function showNewTodoForm() {
            let url = "{{ route('admin.todo-items.create') }}"

            $.ajaxModal('#application-md-modal', url);
        }

        function initSortable() {
            let updates = {'pending-tasks': false, 'completed-tasks': false};
            let completedFirstPosition = $('#completed-tasks').find('li.draggable').first().data('position');
            let pendingFirstPosition = $('#pending-tasks').find('li.draggable').first().data('position');

            $('#pending-tasks').sortable({
                connectWith: '#completed-tasks',
                cursor: 'move',
                handle: '.handle',
                stop: function (event, ui) {
                    const id = ui.item.data('id');
                    const oldPosition = ui.item.data('position');

                    if (updates['pending-tasks']===true && updates['completed-tasks']===true)
                    {
                        const inverseIndex =  completedFirstPosition > 0 ? completedFirstPosition - ui.item.index() + 1 : 1;
                        const newPosition = inverseIndex;

                        updateTodoItem(id, position={oldPosition, newPosition}, status='completed');

                    }
                    else if(updates['pending-tasks']===true && updates['completed-tasks']===false)
                    {
                        const newPosition = pendingFirstPosition - ui.item.index();

                        updateTodoItem(id, position={oldPosition, newPosition});
                    }

                    //finally, clear out the updates object
                    updates['pending-tasks']=false;
                    updates['completed-tasks']=false;
                },
                update: function (event, ui) {
                    updates[$(this).attr('id')] = true;
                }
            }).disableSelection();

            $('#completed-tasks').sortable({
                connectWith: '#pending-tasks',
                cursor: 'move',
                handle: '.handle',
                stop: function (event, ui) {
                    const id = ui.item.data('id');
                    const oldPosition = ui.item.data('position');

                    if (updates['pending-tasks']===true && updates['completed-tasks']===true)
                    {
                        const inverseIndex =  pendingFirstPosition > 0 ? pendingFirstPosition - ui.item.index() + 1 : 1;
                        const newPosition = inverseIndex;

                        updateTodoItem(id, position={oldPosition, newPosition}, status='pending');
                    }
                    else if(updates['pending-tasks']===false && updates['completed-tasks']===true)
                    {
                        const newPosition = completedFirstPosition - ui.item.index();

                        updateTodoItem(id, position={oldPosition, newPosition});
                    }

                    //finally, clear out the updates object
                    updates['pending-tasks']=false;
                    updates['completed-tasks']=false;
                },
                update: function (event, ui) {
                    updates[$(this).attr('id')] = true;
                }
            }).disableSelection();
        }
        function updateTodoItem(id, pos, status=null) {
            let data = {
                _token: '{{ csrf_token() }}',
                id: id,
                position: pos,
            };

            if (status) {
                data = {...data, status: status}
            }

            $.easyAjax({
                url: "{{ route('admin.todo-items.updateTodoItem') }}",
                type: 'POST',
                data: data,
                container: '#todo-items-list',
                success: function (response) {
                    $('#todo-items-list').html(response.view);
                    initSortable();
                }
            });
        }

        function showUpdateTodoForm(id) {
            let url = "{{ route('admin.todo-items.edit', ':id') }}"
            url = url.replace(':id', id);

            $.ajaxModal('#application-md-modal', url);
        }

        function deleteTodoItem(id) {
            swal({
                title: "@lang('errors.areYouSure')",
                text: "@lang('errors.deleteWarning')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('app.delete')",
                cancelButtonText: "@lang('app.cancel')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {
                    let url = "{{ route('admin.todo-items.destroy', ':id') }}";
                    url = url.replace(':id', id);

                    let data = {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    }

                    $.easyAjax({
                        url,
                        data,
                        type: 'POST',
                        container: '#roleMemberTable',
                        success: function (response) {
                            if (response.status == 'success') {
                                $('#todo-items-list').html(response.view);
                                initSortable();
                            }
                        }
                    })
                }
            });
        }

        @if ($user->roles->count() > 0)
            $('#todo-items-list').html(``);
        @endif

        initSortable();

        $('body').on('click', '#create-todo-item', function () {
            $.easyAjax({
                url: "{{route('admin.todo-items.store')}}",
                container: '#createTodoItem',
                type: "POST",
                data: $('#createTodoItem').serialize(),
                success: function (response) {
                    if(response.status == 'success'){
                        $('#todo-items-list').html(response.view);
                        initSortable();

                        $('#application-md-modal').modal('hide');
                    }
                }
            })
        });

        $('body').on('click', '#update-todo-item', function () {
            const id = $(this).data('id');
            let url = "{{route('admin.todo-items.update', ':id')}}"
            url = url.replace(':id', id);

            $.easyAjax({
                url: url,
                container: '#editTodoItem',
                type: "POST",
                data: $('#editTodoItem').serialize(),
                success: function (response) {
                    if(response.status == 'success'){
                        $('#todo-items-list').html(response.view);
                        initSortable();

                        $('#application-md-modal').modal('hide');
                    }
                }
            })
        });

        $('body').on('change', '#todo-items-list input[name="status"]', function () {
            const id = $(this).data('id');
            let status = 'pending';

            if ($(this).is(':checked')) {
                status = 'completed';
            }

            updateTodoItem(id, null, status);
        })

        $(document).ready(function(){
           $("#submit").on('click',function (event){
            event.preventDefault();
            $.easyAjax({
                url : "resume",
                type : "POST",
                data : $("#submit-form").serializeArray(),
                success : function(success){
                    console.log(success);
                }

            });
           });
        });
        
    </script>
@endpush