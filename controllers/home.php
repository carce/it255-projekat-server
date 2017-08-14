<?php

$home = array(
    'index' => function() {
        return '
            <h1>Welcome to the Friziranje API</h1>
            <p>Here you can find some info about the endpoints.</p>
            <br>
            <p>List of endpoints:</p>
            <table>
                <tr>
                    <th>URL</th>
                    <th>Description</th>
                </tr>
                <tr>
                    <td>/</td>
                    <td>Home (you are here)</td>
                </tr>
                <tr>
                    <td>/reservations</td>
                    <td>List of reservations of a customer</td>
                </tr>
                <tr>
                    <td>...</td>
                    <td>...</td>
                </tr>
            </table>
        ';
    },
    'version' => function() {
        return json_encode(array('version' => '1.0.0'));
    }
);