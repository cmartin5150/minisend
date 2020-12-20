@extends('layouts.app')

@section('title', 'Create an Email')

@section('content')
    <table>
    	<tr>
    		<td>ID:</td>
    		<td>{{ $email->id }}</td>
    	</tr>
    	<tr>
    		<td>Status:</td>
    		<td>{{ $email->status->name }}</td>
    	</tr>
    	<tr>
    		<td>Send Attempts:</td>
    		<td>{{ $email->send_attempts }}</td>
    	</tr>
    	<tr>
    		<td>From:</td>
    		<td>{{ $email->from }}</td>
    	</tr>
    	<tr>
    		<td>To:</td>
    		<td>{{ $email->to }}</td>
    	</tr>
    	<tr>
    		<td>Subject:</td>
    		<td>{{ $email->subject }}</td>
    	</tr>
    	<tr>
    		<td>Content (Plaintext):</td>
    		<td>{{ $email->content_plain }}</td>
    	</tr>
    	<tr>
    		<td>Content (HTML):</td>
    		<td>{{ $email->content_html }}</td>
    	</tr>
    </table>
@endsection