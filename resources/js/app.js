import "./bootstrap";

import { Tabulator } from "tabulator-tables";

// Initialize Tabulator
const table = new Tabulator("#tabulator-container", {
    columns: [
        { title: "#", field: "id", headerSort: false },
        { title: "Name", field: "name" },
        { title: "Price", field: "price" },
        { title: "Qty", field: "quantity" },
    ],
    layout: "fitColumns",
    pagination: true,
    tableClass: "table table-bordered table-striped",
    headerSortTristate: true,
});

// Retrieve data using Axios
axios
    .get("api-product")
    .then((response) => {
        console.info(response);
        const data = response.data;
        table.setData(data);
    })
    .catch((error) => {
        // Handle error
        console.error(error);
    });
