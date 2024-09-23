
const baseUrl = 'http://127.0.0.1:8000'

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
try {
    
    const a = document.querySelectorAll('.commonpid');
    let data = [];

    a.forEach(item => {
        data.push(item.innerHTML);  // Ensure the value is what you need
    });

    // Send a POST request with the data to the backend
    fetch(`${baseUrl}/admin/cart/product`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken  // Include the CSRF token in the request
        },
        body: JSON.stringify({ products: data })  // Send the array of products
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error in request: ' + response.statusText);
        }
        return response.json();  // Parse JSON response
    })
    .then(result => {
        console.log(result);
        const a = document.getElementById('productTR')

        a.innerHTML += `
        <th class="px-4 py-2">Image</th>
        <th class="px-4 py-2">Price</th>
        `
        const e = document.getElementById('fortotal')
        let total = 0
        result.forEach(item=>{
            let b = document.getElementById(item.id)
            let c = document.getElementById(`pr${item.id}`)
            let neet = item.price* parseInt(c.getAttribute('data-qty'))
            b.innerHTML += `
            <img width="100px" src="${baseUrl}/uploads/${item.image}" alt="">
            `
            c.innerHTML += `
            Price:${neet}
            `
            total += neet
        })
        e.innerHTML = `Total: ${total}`
        
    })
    .catch(error => {
        console.error('Error:', error);  // Handle errors
    });
    

    

} catch (error) {
    console.log(error);
    
}