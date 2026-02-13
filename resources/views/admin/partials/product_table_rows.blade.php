@foreach ($product_lists as $product)
    @php
        $variants = $product->productAttr;
        $variantCount = $variants->count();
    @endphp

    <tr>
        <td>{{ $product->id }}</td>

        <td>
            <button type="button" class="btn btn-outline-info px-4 radius-30"
                data-bs-toggle="modal"
                data-bs-target="#productModal"
                onclick="fetchData({{ $product->id }})">
                Update
            </button>
            <button
                onclick="deleteData('{{ addslashes($product->id) }}', 'products')"
                class="btn btn-outline-danger px-5 radius-30">Delete</button>
        </td>

        <td>{{ $product->brand->text ?? '-' }}</td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->slug }}</td>

        <td>
            @if ($product->image)
                <img src="{{ asset($product->image) }}" width="60" height="60" alt="Product Image">
            @else
                No Image
            @endif
        </td>

        <td>
            @php $isActive = $product->status == '1'; @endphp
            <span class="badge {{ $isActive ? 'bg-success' : 'bg-danger' }}">
                {{ $isActive ? 'Active' : 'Inactive' }}
            </span>
        </td>

        {{-- COLOR --}}
        <td>
            @foreach ($variants->take(2) as $attr)
                <div>{{ $attr->color->text ?? '-' }}</div>
            @endforeach
            @if ($variantCount > 2)
                <small class="text-muted fst-italic">
                    +{{ $variantCount - 2 }} more — click update to see
                </small>
            @endif
        </td>

        {{-- SIZE --}}
        <td>
            @foreach ($variants->take(2) as $attr)
                <div>{{ $attr->size->text ?? '-' }}</div>
            @endforeach
            @if ($variantCount > 2)
                <small class="text-muted fst-italic">
                    +{{ $variantCount - 2 }} more click update to see
                </small>
            @endif
        </td>

        {{-- MRP --}}
        <td>
            @foreach ($variants->take(2) as $attr)
                <div>{{ $attr->mrp ?? '-' }}</div>
            @endforeach
            @if ($variantCount > 2)
                <small class="text-muted fst-italic">
                    +{{ $variantCount - 2 }} more click update to see
                </small>
            @endif
        </td>

        {{-- PRICE --}}
        <td>
            @foreach ($variants->take(2) as $attr)
                <div>{{ $attr->price ?? '-' }}</div>
            @endforeach
            @if ($variantCount > 2)
                <small class="text-muted fst-italic">
                    +{{ $variantCount - 2 }} more click update to see
                </small>
            @endif
        </td>

        {{-- QTY --}}
        <td>
            @foreach ($variants->take(2) as $attr)
                <div>{{ $attr->qty ?? '-' }}</div>
            @endforeach
            @if ($variantCount > 2)
                <small class="text-muted fst-italic">
                    +{{ $variantCount - 2 }} more click update to see
                </small>
            @endif
        </td>

        {{-- HEIGHT --}}
        <td>
            @foreach ($variants->take(2) as $attr)
                <div>{{ $attr->height ?? '-' }}</div>
            @endforeach
            @if ($variantCount > 2)
                <small class="text-muted fst-italic">
                    +{{ $variantCount - 2 }} more click update to see
                </small>
            @endif
        </td>

        {{-- WEIGHT --}}
        <td>
            @foreach ($variants->take(2) as $attr)
                <div>{{ $attr->weight ?? '-' }}</div>
            @endforeach
            @if ($variantCount > 2)
                <small class="text-muted fst-italic">
                    +{{ $variantCount - 2 }} more click update to see
                </small>
            @endif
        </td>

        {{-- TAX --}}
        <td>{{ $product->tax->text ?? '-' }}</td>
    </tr>
@endforeach
