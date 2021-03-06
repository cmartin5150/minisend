@extends('layouts.app')

@section('title', 'Email List')

@section('content')

    <div id="email_list">
    
    	<div>
    		<input type="text" v-model="from" value="" placeholder="Sender">
        	<input type="text" v-model="to" value="" placeholder="Recipient">
        	<input type="text" v-model="subject" value="" placeholder="Subject">
        	
        	<select v-model="status_id">
        		<option value="0">All</option>    		
        		@foreach ($statuses as $status)
            		<option value="{{ $status->status_id }}">{{ $status->name }}</option>
        		@endforeach    		
        	</select>
        	
        	<button v-on:click="submitSearch">Search</button>
        	
    	</div>
        
        <div>
        	<button v-on:click="processQueue">Process Queued Emails</button>
        </div>
        
        <table v-if="emailList.length">
        	<thead>
        		<th>ID</th>
        		<th>From</th>
        		<th>To</th>
        		<th>Subject</th>
        		<th>Status</th>
        		<th>Send Attempts</th>
        		<th>Actions</th>
        	</thead>
        	<tbody>
        		<tr v-for="email in emailList">
        			<td>@{{ email.id }}</td>
        			<td>@{{ email.from }}</td>
        			<td>@{{ email.to }}</td>
        			<td>@{{ email.subject }}</td>
        			<td>@{{ email.status.name }}</td>
        			<td>@{{ email.send_attempts }}</td>
        			<td><a :href="'/show_email/' + email.id">View</a></td>            		
        		</tr>
        	</tbody>
		</table>        	
		<p v-else>No Items Found</p>
		
		<div>
			<p>Results: @{{ total_results }}</p>
		</div>
		
		<div>
			<button v-on:click="firstPage" :disabled="current_page == 1">First Page</button>
			<button v-on:click="prevPage" :disabled="prev_page_url == null">Previous Page</button>
			<button v-on:click="nextPage" :disabled="next_page_url == null">Next Page</button>
			<button v-on:click="lastPage" :disabled="current_page == last_page">Last Page</button>
		</div>
    </div> 
       
@endsection