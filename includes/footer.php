<footer>
    <p>
        © <?php echo date("Y"); ?> AgroService
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>
function abrirImagem(src){
    document.getElementById('imagemAmpliada').src = src;
    document.getElementById('modalImagem').style.display = 'flex';
}

function fecharImagem(){
    document.getElementById('modalImagem').style.display = 'none';
}
</script>

</body>
</html>