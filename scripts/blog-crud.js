// Blog Post yang udah ada di hardcode
let blogPosts = [
    {
        id: 1,
        title: "🌊 Menjaga Kebersihan Laut",
        content: "Sampah plastik di laut menjadi ancaman serius bagi kehidupan laut. Mari kita mulai dari hal kecil seperti mengurangi penggunaan plastik sekali pakai...",
    },
    {
        id: 2,
        title: "🐢 Konservasi Penyu di Pantai Selatan",
        content: "Program pelestarian penyu berhasil meningkatkan jumlah telur yang menetas hingga 30%. Masyarakat sekitar berperan penting dalam menjaga ekosistem pantai...",
    }
];

let nextId = 3;

function printPost() {
    const blogList = document.querySelector('.blog-list');
    
    const title = blogList.querySelector('.section-title');
    blogList.innerHTML = '';
    blogList.appendChild(title);
    
    blogPosts.forEach(post => {
        const article = document.createElement('article');
        article.className = 'blog-post';
        article.innerHTML = `
            <h3>${post.title}</h3>
            <p class="content">${post.content}</p>
            <div class="crud-buttons">
                <button class="btn edit-post-btn" data-id="${post.id}">Edit</button>
                <button class="btn delete-btn delete-post-btn" data-id="${post.id}">Delete</button>
            </div>
        `;
        blogList.appendChild(article);
    });
    
    // TOmbol edit
    document.querySelectorAll('.edit-post-btn').forEach(btn => {
        btn.addEventListener('click', editPost);
    });
    
    // Tombol delete
    document.querySelectorAll('.delete-post-btn').forEach(btn => {
        btn.addEventListener('click', deletePost);
    });
}

// CREATE
function createPost(e) {
    e.preventDefault();
    
    const title = document.querySelector('input[name="title"]').value;
    const content = document.querySelector('textarea[name="content"]').value;
    
    if (title && content) {
        const newPost = {
            id: nextId++,
            title: title,
            content: content,
        };
        
        blogPosts.push(newPost);
        printPost();
        
        // Clear input
        document.querySelector('input[name="title"]').value = '';
        document.querySelector('textarea[name="content"]').value = '';
        
        alert('Post berhasil dibuat!');
    }
}

// UPDATE
function editPost(e) {
    const postId = parseInt(e.target.dataset.id);
    const post = blogPosts.find(p => p.id === postId);
    
    if (post) {
        const newTitle = prompt('Edit Title:', post.title);
        const newContent = prompt('Edit Content:', post.content);
        
        if (newTitle !== null && newTitle !== '') {
            post.title = newTitle;
        }
        if (newContent !== null && newContent !== '') {
            post.content = newContent;
        }
        
        printPost();
        alert('Post berhasil di update!');
    }
}

// DELETE
function deletePost(e) {
    const postId = parseInt(e.target.dataset.id);
    
    if (confirm('Apakah anda yakin ingin menghapus post ini?')) {
        blogPosts = blogPosts.filter(p => p.id !== postId);
        printPost();
        alert('Post berhasil dihapus!');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    printPost();
    
    const createForm = document.querySelector('.create-form');
    createForm.addEventListener('submit', createPost);
    
    document.querySelector('.edit-section').style.display = 'none';
    document.querySelector('.delete-section').style.display = 'none';
});