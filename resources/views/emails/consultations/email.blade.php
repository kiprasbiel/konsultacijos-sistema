@component('mail::message')
    {!! nl2br(\App\Option::where('name', 'email_text_new_con')->value('value') )!!}
@endcomponent
