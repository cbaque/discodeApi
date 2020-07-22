<h3>Datos del cliente</h3>

<table>
    <tbody>
    <tr>
        <td><b>Nombre:</b></td><td>{{ $user_details['first_name'] }}</td>
        <td><b>Apellido:</b></td><td>{{ $user_details['last_name'] }}</td>
    </tr>
    <tr>
        <td><b>País:</b></td><td>{{ $user_details['country'] }}</td>
        <td><b>Ciudad:</b></td><td>{{ $user_details['city_state'] }}</td>
    </tr>
    <tr>
        <td><b>Teléfono:</b></td><td>{{ $user_details['mobile'] }}</td>
        <td><b>Email:</b></td><td>{{ $user_details['email'] }}</td>
    </tr>
    </tbody>
</table>

<h3>Productos</h3>
<table border="1">
    <tbody>
        <tr>
            <th>Descripcion</th>
            <th>Cantidad</th>
        </tr>
        @foreach ($cart_products as $product)
            <tr>
                <td>{{ $product['producto'] }}</td>
                <td>{{ $product['quantity'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


