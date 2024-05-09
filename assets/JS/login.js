const form = document.getElementById("form");
const username = document.getElementById("username");
const email = document.getElementById("email");
const password = document.getElementById("password");
const passwordConfirmation = document.getElementById("password-confirmation");
const category = document.getElementById("category");
const subcategoryContainer = document.getElementById("subcategory-container");
const subcategory = document.getElementById("subcategory");
const role = document.getElementById("role");

// Define as subcategorias para cada categoria
const subcategories = {
    tecnologia: ["Desenvolvimento Web", "Desenvolvimento Mobile", "Design UX/UI", "Testes de Software"],
    "design-grafico": ["Design de Logotipo", "Ilustração", "Edição de Imagem", "Arte Vetorial"],
    marketing: ["Marketing Digital", "SEO", "Publicidade Online", "Redes Sociais"],
    "video-animacao": ["Edição de Vídeo", "Animação 2D", "Animação 3D", "Motion Graphics"]
};

//  inicio subcategoria 
category.addEventListener("change", () => {
    subcategory.innerHTML = ""; // subcategoria limpa @mateusmdmmt@gmail.com
    const selectedCategory = category.value;
    const subcategoriesList = subcategories[selectedCategory] || [];
    subcategoriesList.forEach(option => {
        const newOption = document.createElement("option");
        newOption.textContent = option;
        newOption.value = option.toLowerCase().replace(/\s+/g, "-"); 
        subcategory.appendChild(newOption);
    });
});

form.addEventListener("submit", (e) => {
    e.preventDefault();
    checkInputs();
});

function checkInputs() {
  
}