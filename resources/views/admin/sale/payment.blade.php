<td class="col-sm-8">Customer Name</td>
<td class="text-right">
    <select class="form-control" name="customer_id">
        @foreach($customers as $customer)
            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
        @endforeach
    </select>
</td>