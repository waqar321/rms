@if($readyToLoad)
    <div class="d-flex justify-content-between">

        @if($total_records > 10 )
            <div>
                <select wire:model="paginateLimit" class="form-control" style="width: auto;">
                    <option value="10">10 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                    <option value="100">100 per page</option>
                    <option value="500">500 per page</option>
                </select>
            </div>
        @endif     
        <div>
            {{ $ModelListing->links() }} 
        </div>
    </div>
@endif 