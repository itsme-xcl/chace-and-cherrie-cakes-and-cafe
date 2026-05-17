@if($page === 'maintenance')

@php
    $label = ucfirst(rtrim($section, 's'));
@endphp

<!-- HEADER -->
<div class="section-header">
    <h2>{{ $label }} Management</h2>

    <div class="section-toolbar">
        <div class="category-tabs">
            <a href="?page=maintenance&section=flavors" class="tab {{ $section==='flavors'?'active':'' }}">Flavors</a>
            <a href="?page=maintenance&section=sizes" class="tab {{ $section==='sizes'?'active':'' }}">Sizes</a>
            <a href="?page=maintenance&section=addons" class="tab {{ $section==='addons'?'active':'' }}">Add-ons</a>
            <a href="?page=maintenance&section=themes" class="tab {{ $section==='themes'?'active':'' }}">Themes</a>
            <a href="?page=maintenance&section=frostings" class="tab {{ $section==='frostings'?'active':'' }}">Frosting</a>
            <a href="?page=maintenance&section=fondants" class="tab {{ $section==='fondants'?'active':'' }}">Fondant</a>
        </div>

        @if(!request()->has('add') && !$editItem)
        <a href="?page=maintenance&section={{ $section }}&add=1" class="btn-primary">
            + Add {{ $label }}
        </a>
        @endif
    </div>
</div>


<!-- ADD / EDIT FORM -->
@if(request()->has('add') || $editItem)
<div class="card">
    <h3>{{ $editItem ? 'Edit' : 'Add' }} {{ $label }}</h3>

    <form method="POST"
        action="{{ $editItem 
            ? "/admin/$section/$editItem->id/update" 
            : "/admin/$section/store" }}">
        @csrf

        <div class="form-row">
            <input type="text" name="name"
                value="{{ $editItem->name ?? '' }}"
                placeholder="Name" required>

            <input type="number" name="additional_price"
                value="{{ $editItem->additional_price ?? 0 }}"
                placeholder="Price" required>
        </div>

        <div class="form-actions">
            <button class="btn-primary">
                {{ $editItem ? 'Update' : 'Save' }}
            </button>
        </div>
    </form>
</div>
@endif


<!-- TABLE -->
<div class="card">
    <h3>{{ $label }} List</h3>

    @if($items->count() === 0)
        <p>No data yet.</p>
    @else
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        @foreach($items as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>₱{{ number_format($item->additional_price,2) }}</td>

            <!-- STATUS -->
            <td>
                <form method="POST" action="/admin/{{ $section }}/{{ $item->id }}/toggle">
                    @csrf
                    <button class="status {{ $item->status }}">
                        {{ ucfirst($item->status) }}
                    </button>
                </form>
            </td>

            <!-- ACTIONS -->
            <td class="actions">
                <a href="?page=maintenance&section={{ $section }}&edit={{ $item->id }}">✏️</a>

                <form method="POST" action="/admin/{{ $section }}/{{ $item->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">🗑️</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>

@endif