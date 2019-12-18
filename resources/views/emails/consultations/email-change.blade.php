@component('mail::message')
    {!! nl2br(\App\Option::where('name', 'email_text_edited_con')->value('value') )!!}
@endcomponent
