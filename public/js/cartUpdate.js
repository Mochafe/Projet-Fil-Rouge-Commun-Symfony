let select = document.getElementsByClassName("quantity");

for(let element of select) {
    element.addEventListener("change", () => {
        fetch(`/cart/update?id=${element.dataset.id}&quantity=${element.value}`);
    });
}