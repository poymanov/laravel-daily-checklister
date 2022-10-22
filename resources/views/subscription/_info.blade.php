<div>
    <form action="{{ route('subscription.destroy') }}" method="post" onsubmit="return confirm('Are you sure?');">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger">Cancel</button>
    </form>
</div>
