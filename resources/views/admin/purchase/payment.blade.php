<td class="col-sm-8">Supplier Name</td>
<td class="text-right">
    <select class="form-control" name="supplier_id">
        @foreach($suppliers as $supplier)
            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
        @endforeach
    </select>
</td>