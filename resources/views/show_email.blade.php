@extends('layouts.app')

@section('title', 'Create an Email')

@section('content')
    <table>
    	<tr>
    		<td>ID:</td>
    		<td><input readonly value="{{ $email->id }}"></td>
    	</tr>
    	<tr>
    		<td>Status:</td>
    		<td><input readonly value="{{ $email->status->name }}"></td>
    	</tr>
    	<tr>
    		<td>Send Attempts:</td>
    		<td><input readonly value="{{ $email->send_attempts }}"></td>
    	</tr>
    	<tr>
    		<td>From:</td>
    		<td><input readonly value="{{ $email->from }}"></td>
    	</tr>
    	<tr>
    		<td>To:</td>
    		<td><input readonly value="{{ $email->to }}"></td>
    	</tr>
    	<tr>
    		<td>Subject:</td>
    		<td><input readonly value="{{ $email->subject }}"></td>
    	</tr>
    	<tr>
    		<td>Content (Plaintext):</td>
    		<td><textarea rows=10 readonly>{{ $email->content_plain }}</textarea></td>
    	</tr>
    	<tr>
    		<td>Content (HTML):</td>
    		<td><textarea rows=10 readonly>{{ $email->content_html }}</textarea></td>
    	</tr>    	
    </table>
@endsection