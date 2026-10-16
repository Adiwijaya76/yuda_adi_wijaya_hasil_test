<a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-light" title="Edit">
    <i class="fa-solid fa-pen"></i>
</a>
<form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline"
    onsubmit="return confirm('Hapus akun {{ $user->name }}?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-light text-danger" title="Hapus">
        <i class="fa-solid fa-trash"></i>
    </button>
</form>
