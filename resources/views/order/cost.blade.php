<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
@section('container')
    <section class="p-5 mx-2 mt-2 shadow rounded">

        <h2 class="text-lg font-semibold capitalize">Cost</h2>
        <form action="/dashboard/order/postCost-{{ $order->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="origin" id="hiddenOrigin" value="">
            <input type="hidden" name="destination" id="hiddenDestination" value="">

            <select name="" id="origin" class="form-control m-2">
                <option value="">Loading...</option>
            </select>
            <select name="" id="destination" class="form-control m-2">
                <option name="" value="">Loading...</option>
            </select>
            <select name="courier" id="courier" class="form-control m-2">
                <option value="">Pilih kurir</option>
                <option value="jne">JNE</option>
                <option value="tiki">TIKI</option>
                <option value="pos">POS INDONESIA</option>
                <option value="sicepat">Sicepat</option>
                <option value="jnt">JNT</option>
            </select>
            <input class="form-control m-2" name="weight" value="" placeholder="weight">
            <button type="submit" class="btn btn-primary m-2" style="background-color: blue; color: white;">Submit</button>
        </form>


        @if (session('success'))
            @php
                $successData = session('success');
                $order = $successData['order'];
                $allCosts = json_decode($successData['allCosts'], true);
                $cart = $successData['cart'];
                $address = $successData['address'];
            @endphp
            @if ($allCosts)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Value</th>
                            <th>ETD</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allCosts as $cost)
                            <h2 class="ml-3" style="font-style: italic; font-size: 17px">{{ $cost['name'] }}</h2>
                            @foreach ($cost['costs'] as $subCost)
                                <tr>
                                    <td>{{ $subCost['description'] }}</td>
                                    <td>Rp{{ number_format($subCost['value'], 0, ',', '.') }}</td>
                                    <td>{{ $subCost['etd'] }} Hari</td>
                                    <td>
                                        @if (!empty($subCost['note']))
                                            {{ $subCost['note'] }}
                                        @else
                                            No notes available
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No cost information available.</p>
            @endif
            <!-- ... other data ... -->
        @endif

    </section>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {

            // const apiUrl = '/rajaongkir/cities';
            const cityDetailsUrl = '/rajaongkir/cities-detail';

            function fetchCities(selectElement, hiddenInput) {
                $.ajax({
                    url: '/rajaongkir/cities-detail/' + {{ $address->city }},
                    type: 'GET',

                    success: function(data) {
                        if (data.rajaongkir && data.rajaongkir.results) {
                            const city = data.rajaongkir.results;
                            console.log(city);
                            $(selectElement).prop('disabled', true);
                            $(selectElement).append('<option value="' + city.city_id +
                                '" selected>' + city.city_name + '</option>');
                            $(hiddenInput).val(city.city_id);
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching city details:', error);
                    }
                });
            }

            function fetchCityDetails(selectElement, hiddenInput) {
                $.ajax({
                    url: '/rajaongkir/cities-detail/' + 399,
                    type: 'GET',

                    success: function(data) {
                        if (data.rajaongkir && data.rajaongkir.results) {
                            const city = data.rajaongkir.results;
                            console.log(city);
                            $(selectElement).prop('disabled', true);
                            $(selectElement).append('<option value="' + city.city_id +
                                '" selected>' + city.city_name + '</option>');
                            $(hiddenInput).val(city.city_id);
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching city details:', error);
                    }
                });
            }

            fetchCities('#destination', '#hiddenDestination');
            fetchCityDetails('#origin', '#hiddenOrigin');

        });
    </script>
@endsection
