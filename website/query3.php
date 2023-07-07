<!DOCTYPE html>
<html>
    <head>
        <title>Explorador de Datos E-Commerce Brasil</title>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link rel="icon" type="image/x-icon" href="favicon.png">
    </head>
<body>
    <?php
        $variable0=$_GET['pcategory'];
        echo "<h1>" . "Vendedor con más ventas por categoría: " . $variable0 . "</h1>";

        echo "<table>";
        echo "<tr>
                <th> Vendedor </th>
                <th> Total ventas </th>
              </tr>";

        class TableRows extends RecursiveIteratorIterator {
            function __construct($it) {
                parent::__construct($it, self::LEAVES_ONLY);
            }
            function current() {
                return "<td>" . parent::current(). "</td>";
            }
            function beginChildren() {
                echo "<tr>";
            }
            function endChildren() {
                echo "</tr>" . "\n";
            }
        }

        try {
           $pdo = new PDO('pgsql:
                           host=localhost;
                           port=5432;
                           dbname=cc3201;
                           user=webuser;
                           password=howareyoufinethankyou');

           $variable1=$_GET['pcategory'];
           $stmt = $pdo->prepare('SELECT seller_id, total_ventas_categoria
                                  FROM olist.totalventascategoria
                                  WHERE product_category = :valor1;'
                                  );

           $stmt->execute(['valor1' => $variable1]);
           $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

           foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
               echo $v;
           }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
        echo "</table>";
    ?>
</body>
</html>
