@component('mail::message')
    {!! nl2br(\App\Option::where('name', 'email_text_month_con')->value('value') )!!}
@endcomponent
