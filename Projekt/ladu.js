document.getElementById('toode').addEventListener('submit',
    function (event) {
        var kogus = Number(document.getElementById('kogus_id').value);
        if (kogus < 0) {
            alert('Mittelubatud väärtus!');
            event.preventDefault();
            return;
        }
    });
