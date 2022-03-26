import $ from "jquery";
require('bootstrap');

import * as net_bs5 from 'datatables.net-bs5'
import dt from 'datatables.net';

$(document).ready(function () {
    console.log('control');

    $('#example').DataTable();
});