@component('mail::message')
    {!! nl2br(\App\Option::where('name', 'email_text_delete_con')->value('value') )!!}
@endcomponent
