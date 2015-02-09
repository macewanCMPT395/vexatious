@extends('layouts.profile')

@section('menu')
        
        <li>
            {{ link_to("/users/{$user->username}/edit", "Edit Profile") }}
        </li>
        
        <li>
            {{ link_to("/", "Sign Out") }}
        </li>
@stop


@section('content')

<?php
$users = DB::table('users')->get();
$users = User::all();
?>

<div class="profile-list">
    @foreach ($users as $u)
    <div class="profile">
        
        <?php

        $CommitmentLevel = "Nebulous";
        if ($u->Type == "0") $CommitmentLevel = "Mild Eye Contact";
        if ($u->Type == "1") $CommitmentLevel = "Hoofing";
        if ($u->Type == "2") $CommitmentLevel = "Prancing";
        if ($u->Type == "3") $CommitmentLevel = "Elope to Peru";

        $Gender = "Nebulous";
        if ($u->Gender == "0") $Gender = "Male";
        if ($u->Gender == "1") $Gender = "Female";
        if ($u->Gender == "2") $Gender = "TransLlama";
        if ($u->Gender == "3") $Gender = "NonGendered";

        $LookingFor = "A Far Away Shore";
        if ($u->SexualOrientation == "0") $LookingFor = "Male";
        if ($u->SexualOrientation == "1") $LookingFor = "Female";
        if ($u->SexualOrientation == "2") $LookingFor = "TransLlama";
        if ($u->SexualOrientation == "3") $LookingFor = "NonGendered";

        ?>
        
        <ul>
            <li>
                {{ HTML::image('images/bhipster.jpg', 'profile pic',array('class' => 'pic')) }}
            </li>
            <li>
                <div class="user-name">{{$u->username}}</div>
                <div class="user-info">
                    <ul>
                        <li>
                            Gender: {{$Gender}} <br>
                            Looking For: {{$LookingFor}} <br>
                            
                        </li>
                        <li>
                            Fur Color: {{$u->FurColor}} <br>
                            Commitment Level: {{$CommitmentLevel}} <br>
                        </li>
                        <li>
                            Interests: {{$u->Interests}} <br>
                            Email: {{$u->Email}} <br>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    @endforeach
</div>

@stop

