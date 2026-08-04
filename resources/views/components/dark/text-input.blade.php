@props(['disabled' => false, 'icon' => null])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-600 bg-slate-900 text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm']) }}>
