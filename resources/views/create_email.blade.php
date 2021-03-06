@extends('layouts.app')

@section('title', 'Create an Email')

@section('content')
    <form action="{{ route('submit_email') }}" method="post" enctype="multipart/form-data">
    
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
    	    
    	<ul>
    		<li>
    			<input type="text" name="from" value="{{ Request::old('from') }}" placeholder="From Address">
    		</li>
    		<li>
    			<input type="text" name="to" value="{{ Request::old('to') }}" placeholder="To Address">
    		</li>
    		<li>
    			<input type="text" name="subject" value="{{ Request::old('subject') }}" placeholder="Subject">
    		</li>		
    		<li>		
    			<textarea name="content_plain" value="{{ Request::old('content_plain') }}" placeholder="Plaintext Content" rows=10></textarea>
    		</li>
    		<li>		
    			<textarea name="content_html" value="{{ Request::old('content_html') }}" placeholder="HTML Content" rows=10></textarea>
    		</li>
    		<li>
    			<input name="attachment[]" type="file" multiple>
    		</li>
    	</ul>	
    	<input type="submit" value="Send">
    </form>
    
    @if (!empty($errors->all()))
    	Cannot submit email because:
    	<ul>
        	@foreach($errors->all() as $error)
        		<li>
        			{{ $error }}
				</li>
        	@endforeach
    	</ul>
    @endif
@endsection