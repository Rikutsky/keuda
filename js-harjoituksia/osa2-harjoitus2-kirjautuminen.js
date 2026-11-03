let kirjautunut = false;
let admin = false;
let opettaja = false;

if (!kirjautunut) {
    console.log("kirjaudu sisään");
} else if (admin || opettaja) {
    console.log("muokkaus sallittu");
} else {
    console.log("ei muokkausoikeutta");
}