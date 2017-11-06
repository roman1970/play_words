<!Doctype html>
<head>
    <meta charset="utf-8">
    <title>Рубин</title>
</head>
<body>
<div align="center">
    <div style="width: 400px">
        <h1>Мишина книга</h1>
        <hr>
        <p align="left">Сегодня играли <br> команды </p>
        <img src="images/rain.png" width="200px">
        <h2>Лучшие</h2>
        <ol>
            <li title="юве"> Ювентус</li>
            <li>Фина</li>
            <li>Мишка</li>
        </ol>
        <table border="2">
            <tr>
                <td bgcolor="aqua" width="50px">№</td>
                <td width="150px">Команда</td>
                <td width="150px">Мячи</td>
                <td width="150px">Очки</td>
            </tr>
            <tr>
                <td height="20px"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td height="20px"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td height="20px"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td height="20px"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td height="20px"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

        </table>
        <form action="our_action.php" method="post">
            <p align="left">
                <input type="text" name="имя">
            </p>
            <p align="left">
                <input hidden value="1">
                <input type="radio" name="fyt" value="0">
            </p>
            <p align="left">
                <input type="radio" name="fyt" value="1">
            </p>
            <p>
                <input type="checkbox" name="yuh" checked value="5">
            </p>
            <p>
                <input type="checkbox" name="yuhuuu" checked value="6">
            </p>
            <p>
                <input type="submit" value="отправить">
            </p>
        </form>
    </div>
</div>

</body>