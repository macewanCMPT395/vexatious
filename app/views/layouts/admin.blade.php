@extends('layouts.header')

@section('adminButtons')
<div class="button">{{ HTML::linkRoute('kits.edit', 'Edit Kits') }}</div>
<div class="button">{{ HTML::linkRoute('users.edit', 'Edit Users') }}</div>
@stop