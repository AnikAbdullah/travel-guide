function calculateCost() {

    let days = parseFloat(
        document.getElementById("days").value
    ) || 0;

    let hotel = parseFloat(
        document.getElementById("hotel").value
    ) || 0;

    let food = parseFloat(
        document.getElementById("food").value
    ) || 0;

    let transport = parseFloat(
        document.getElementById("transport").value
    ) || 0;

    let total =
        (hotel * days) +
        (food * days) +
        transport;

    document.getElementById(
        "totalCost"
    ).innerHTML = "Estimated Total Cost: $" + total;
}