<?php
require_once 'src/controller/book.php';
require_once 'src/controller/sheet.php';

// Obtener el libro seleccionado del formulario (si existe)
$libro_seleccionado = $_POST['libros'] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tituloLibro'])) {
    $titulo = trim($_POST['tituloLibro']);
    if (!empty($titulo)) {
        $resultado = CreateBook($titulo); // Llamas a la función que guarda el libro en la base de datos
        if ($resultado) {
            echo "<script>alert('Libro agregado correctamente');</script>";
        } else {
            echo "<script>alert('Error al agregar el libro');</script>";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nuevoTitulo']) && isset($_POST['nuevoContenido'])) {
    $titulo = trim($_POST['nuevoTitulo']);
    $contenido = trim($_POST['nuevoContenido']);
    $libro_id = $_POST['libro_seleccionado'];

    if (!empty($titulo) && !empty($contenido)) {
        $resultado = CreateSheet($libro_id, $titulo, $contenido); // Llamas a la función que guarda el libro en la base de datos
        if (!$resultado) {
            echo "<script>alert('Error al agregar el contenido');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-gray-200">
    <div class="max-w-5xl mx-auto p-8 mt-10 bg-gray-800 shadow-lg rounded-lg">

        <!-- Título -->
        <h1 class="text-4xl font-bold text-center text-white mb-8">📚 Biblioteca Virtual</h1>

        <!-- Selección de libros -->
        <form method="POST" action="" class="mb-6">
            <label for="libros" class="block text-lg font-medium text-gray-300 mb-2">Selecciona un libro:</label>
            <div class="flex items-center space-x-4">
                <select id="libros" name="libros" onchange="this.form.submit()"
                    class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200">
                    <option value="">-- Seleccionar --</option>
                    <?php
                    // Obtener la lista de libros
                    $books = bookList();
                    foreach ($books as $book) {
                        $selected = ($libro_seleccionado == $book['id_book']) ? 'selected' : '';
                        echo "<option value=\"$book[id_book]\" $selected>$book[id_book] -  $book[title]</option>";
                    }
                    ?>
                </select>

                <!-- Botón para agregar nuevo libro -->
                <button type="button" onclick="mostrarModal()"
                    class="px-5 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition duration-200">Agregar Libro
                </button>
            </div>
        </form>

        <!-- Contenedor de las páginas del libro -->
        <div class="mt-8">
            <?php
            if ($libro_seleccionado) {
                $sheets = ListSheet($libro_seleccionado);
                if (empty($sheets)) {
                    echo "<form method='POST' class='space-y-4'>";
                    echo "<div class='flex flex-col space-y-4'>";
                    echo "<input type='hidden' id='libro_seleccionado' name='libro_seleccionado' value='" . $libro_seleccionado . "'></input>";
                    echo "<input type='text' class='w-full p-3 bg-gray-700 border border-gray-600 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200 text-white placeholder-gray-400' name='nuevoTitulo' placeholder='Nuevo título' value='' id='nuevoTitulo' required>";
                    echo "<textarea class='w-full p-3 bg-gray-700 border border-gray-600 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200 text-white placeholder-gray-400 resize-none' name='nuevoContenido' placeholder='Nuevo contenido' id='nuevoContenido' rows='4' required></textarea>";
                    echo "</div>";
                    echo "<button type='submit' class='w-full px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200 text-xl'>Guardar</button>";
                    echo "</form>";
                    echo "<p class='text-center text-gray-400 italic'>No hay contenido disponible para este libro.</p>";
                } else {
                    foreach ($sheets as $sheet) : ?>
                        <div class="bg-gray-700 p-6 rounded-lg shadow-lg mb-6">
                            <form method="POST">
                                <input type='hidden' name='libro_seleccionado' value='<?php echo $sheet['id_sheet']; ?>'>
                                <div class="form-group flex items-center space-x-2 mb-2">
                                    <input type='text' class='form-control w-full p-3 bg-gray-700 border border-gray-600 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200 text-white placeholder-gray-400 border-none' name='nuevoTitulo' placeholder='Nuevo título' value='<?php echo htmlspecialchars($sheet['title']); ?>' id='nuevoTitulo'>
                                    <button type="submit" class="form-control px-6 py-3 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">Guardar</button>
                                </div>
                                <textarea class="form-control w-full p-3 bg-gray-700 border border-gray-600 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200 text-white placeholder-gray-400 resize-none border-none" name='nuevoContenido' placeholder='Nuevo contenido' id='nuevoContenido' rows='4'><?php echo nl2br(htmlspecialchars($sheet['content'])); ?></textarea>
                                <div class="flex justify-end space-x-2">
                                    <button type="button" onclick="eliminarHoja('<?php echo $sheet['id_sheet']; ?>')" class="px-5 py-2 bg-red-500 text-white rounded-lg shadow-md hover:bg-red-600 transition duration-200">Eliminar</button>
                                </div>
                            </form>
                        </div>
            <?php endforeach;
                }
            } else {
                echo "<p class='text-center text-gray-400 italic'>Selecciona un libro para ver su contenido.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Modal para agregar un nuevo libro -->
    <div id="modalNuevoLibro" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg w-96">
            <h3 class="text-xl font-semibold text-white mb-4">Agregar Nuevo Libro</h3>
            <form method="POST">
                <label for="tituloLibro" class="block text-gray-300 font-medium mb-2">Título del libro:</label>
                <input type="text" id="tituloLibro" name="tituloLibro" required
                    class="w-full p-3 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200"
                    placeholder="Ingrese el título del libro">

                <div class="flex justify-end mt-4 space-x-2">
                    <button type="button" onclick="cerrarModal()"
                        class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>

<script>
    function mostrarModal() {
        document.getElementById('modalNuevoLibro').classList.remove('hidden');
    }

    function cerrarModal() {
        document.getElementById('modalNuevoLibro').classList.add('hidden');
    }
</script>

</html>