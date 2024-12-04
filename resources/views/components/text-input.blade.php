@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-none dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-none dark:focus:border-indigo-600 focus:ring-0 focus:shadow-xl dark:focus:ring-indigo-600 rounded-md shadow-md']) !!}>
