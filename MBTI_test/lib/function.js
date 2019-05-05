function checkSurely() {
    var message = "작성한 검사 결과가 사라지고 다시 시작합니다.\n";
    message += "정말 다시 검사하시겠습니까?";
    if (confirm(message)) {
        location.href = "process_retest.php";
    }
}

function checkAllSelected() {
    var question1 = document.querySelectorAll('.qst1');
    var question2 = document.querySelectorAll('.qst2');
    for (var i = 0; i < question1.length; i++) {
        if (!question1[i].checked && !question2[i].checked) {
            alert(`${i + 1}번째 문제를 아직 선택하지 않았습니다!!`);
            return false;
        }
    }
    return true;
}

function addTypesEvent() {
    var typeDiv = document.querySelector('.typebox');
    var types = typeDiv.getElementsByTagName('h2');
    for (var i = 0; i < types.length; i++) {
        types[i].addEventListener("mouseover", function (e) {
            var typeName = e.srcElement.innerHTML;
            var content = document.getElementById(typeName);
            content.style.display = 'grid';
            var homeButton = document.getElementById('home');
            homeButton.style.display = "none";
        });
        types[i].addEventListener("mouseout", function (e) {
            var typeName = e.srcElement.innerHTML;
            var content = document.getElementById(typeName);
            content.style.display = 'none';
            var homeButton = document.getElementById('home');
            homeButton.style.display = "block";
        });
    }
}

function drawScoreCircle(id, score) {
    var canvas = document.getElementById(id);
    var ctx = canvas.getContext("2d");
    var circleW = canvas.width / 9;
    var circleH = canvas.height / 2;
    var radius = circleW / 2 - 1;
    var start = circleW * 4.5;
    var vScore = (score < 0) ? score * -1 : score;
    var circleCnt = parseInt((vScore - 1) / 2);

    ctx.lineWidth = 2;
    ctx.strokeStyle = "gray";
    for (var i = 0; i < 9; i++) {
        ctx.beginPath();
        ctx.arc(circleW * (i + 0.5), circleH, radius, 0, 2 * Math.PI);
        ctx.stroke();
    }

    ctx.fillStyle = "gray";
    if (score < 0) {
        ctx.beginPath();
        ctx.arc(start, circleH, radius, 1.5 * Math.PI, 0.5 * Math.PI);
        ctx.fill();
        for (var j = 0; j < circleCnt; j++) {
            start += circleW;
            ctx.beginPath();
            ctx.arc(start, circleH, radius, 0, 2 * Math.PI);
            ctx.fill();
        }
        if (vScore > circleCnt * 2 + 1) {
            start += circleW;
            ctx.beginPath();
            ctx.arc(start, circleH, radius, 0.5 * Math.PI, 1.5 * Math.PI);
            ctx.fill();
        }
    }
    else {
        ctx.beginPath();
        ctx.arc(circleW * 4.5, circleH, radius, 0.5 * Math.PI, 1.5 * Math.PI);
        ctx.fill();
        for (var j = 0; j < circleCnt; j++) {
            start -= circleW;
            ctx.beginPath();
            ctx.arc(start, circleH, radius, 0, 2 * Math.PI);
            ctx.fill();
        }
        if (vScore > circleCnt * 2 + 1) {
            start -= circleW;
            ctx.beginPath();
            ctx.arc(start, circleH, radius, 1.5 * Math.PI, 0.5 * Math.PI);
            ctx.fill();
        }
    }
}
