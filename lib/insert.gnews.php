<?php

require_once "conexao.pdo.php";

/**
* 
*/
class Insert extends connPDO
{
	
	private static $title;
	private static $link;
	private static $guid;
	private static $category;
	private static $pubDate;
	private static $description;

	public $cPDO = null;


	function __construct() {

	}

	public static function InsertNewsGoogle(){
		

		$return = false;

		$cxPDO = parent::getInstance();

		try {

		    $var = 'BA';

		    $stmt = $cxPDO->prepare("INSERT INTO news (title, link, guid, category, pubDate, description) 
		    						 VALUES (:title, :link, :guid, :category, :pubDate, :description)");

		 	$stmt->bindParam(':title', self::getTitle()); 
		 	$stmt->bindParam(':link', self::getLink()); 
		 	$stmt->bindParam(':guid', self::getGuid()); 
		 	$stmt->bindParam(':category', self::getCategory()); 
		 	$stmt->bindParam(':pubDate', self::getPubDate()); 
		 	$stmt->bindParam(':description', self::getDescription()); 

		    if ($stmt->execute()){

			    while ($obj = $stmt->fetch(PDO::FETCH_OBJ)){
			    
			        echo "<b>Nome:</b> " . $obj->ba . " - <b>Telefone:</b> " . $obj->ocorrencia."</br>";
			    }

			    $return = true;
			} else{

				var_dump('Falha ao Obter os Dados !');
			}
		    // fecho o banco
		    $cxPDO = null;
		    // tratamento da exeção
		} catch ( PDOException $e ) {
		    echo $e->getMessage ();
		}	

		return $return;		
	}
	



    /**
     * Gets the value of title.
     *
     * @return mixed
     */
    public static function getTitle()
    {
        return self::$title;
    }
    
    /**
     * Sets the value of title.
     *
     * @param mixed $title the title
     *
     * @return self
     */
    public static function setTitle($title)
    {
        self::$title = $title;

        return $this;
    }

    /**
     * Gets the value of link.
     *
     * @return mixed
     */
    public static function getLink()
    {
        return self::$link;
    }
    
    /**
     * Sets the value of link.
     *
     * @param mixed $link the link
     *
     * @return self
     */
    public static function setLink($link)
    {
        self::$link = $link;

        return $this;
    }

    /**
     * Gets the value of guid.
     *
     * @return mixed
     */
    public static function getGuid()
    {
        return self::$guid;
    }
    
    /**
     * Sets the value of guid.
     *
     * @param mixed $guid the guid
     *
     * @return self
     */
    public static function setGuid($guid)
    {
        self::$guid = $guid;

        return $this;
    }

    /**
     * Gets the value of category.
     *
     * @return mixed
     */
    public static function getCategory()
    {
        return self::$category;
    }
    
    /**
     * Sets the value of category.
     *
     * @param mixed $category the category
     *
     * @return self
     */
    public static function setCategory($category)
    {
        self::$category = $category;

        return $this;
    }

    /**
     * Gets the value of pubDate.
     *
     * @return mixed
     */
    public static function getPubDate()
    {
        return self::$pubDate;
    }
    
    /**
     * Sets the value of pubDate.
     *
     * @param mixed $pubDate the pub date
     *
     * @return self
     */
    public static function setPubDate($pubDate)
    {
        self::$pubDate = $pubDate;

        return $this;
    }

    /**
     * Gets the value of description.
     *
     * @return mixed
     */
    public static function getDescription()
    {
        return self::$description;
    }
    
    /**
     * Sets the value of description.
     *
     * @param mixed $description the description
     *
     * @return self
     */
    public static function setDescription($description)
    {
        self::$description = $description;

        return $this;
    }
}

