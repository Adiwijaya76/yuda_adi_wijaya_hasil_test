<a href="{{ route('merchant.menus.edit', $menu) }}" class="btn btn-sm btn-light" title="Edit">
    <i class="fa-solid fa-pen"></i>
</a>
<form method="POST" action="{{ route('merchant.menus.destroy', $menu) }}" class="d-inline"
    onsubmit="return confirm('Nonaktifkan menu ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-light text-danger" title="Nonaktifkan">
        <i class="fa-solid fa-ban"></i>
    </button>
</form>
