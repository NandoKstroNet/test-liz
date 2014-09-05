<?php
namespace App\Models;

use Liz\Core\Model;

class Perfil extends Model
{
	/**
	 * @var Int
	 */
	private $id;	

	/**
	 * @var String
	 */
	private $name;	

	/**
	 * @var String
	 */
	private $email;

	/**
	 * @var Datetime
	 */
	private $createdAt;

	/**
	 * @var \PDO
	 */
	private $conn;

	/**
	 * Instantiates a new PDO connection
	 */
	public function __construct()
	{
		parent::__construct();
		$this->conn = $this->newConnection();
		$this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	}	
	
	/**
	 * Setters and Getters
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}
	
	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}
	
	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	public function save()
	{
		$sql  = 'INSERT INTO perfis(name, email, createdAt) VALUES(:name, :email, :createdAt)';

		try {

			$insert = $this->conn->prepare($sql);
			$insert->bindValue(':name', $this->name, \PDO::PARAM_STR);
			$insert->bindValue(':email', $this->email, \PDO::PARAM_STR);
			$insert->bindValue(':createdAt', $this->createdAt, \PDO::PARAM_STR);

			if($insert->execute()) {
				return $this->conn->lastInsertId();
			}
			
		} catch(PDOexception $e) {
			return false; #$e->getMessage();
		}
	}

	public function getAll($find = null)
	{
		$sql = 'SELECT * FROM perfis';

		if(null !== $find) {
			$sql .= ' WHERE id = :id';
		}

		try {
			
			$select = $this->conn->prepare($sql);
			
			if(null !== $find) {
				$select->bindValue(':id', $find, \PDO::PARAM_INT);
			}

			$select->execute();
			
			return $select->fetchAll(\PDO::FETCH_ASSOC);

		} catch(PDOexception $e) {
			return false; #$e->getMessage();
		}
	}
	
	public function find($id)
	{
		return $this->getAll($id);
	}

	public function delete($id)
	{
		$sql = "DELETE FROM perfis WHERE id = :id";

		try {
			$delete = $this->conn->prepare($sql);
			$delete->bindValue(':id', $id, \PDO::PARAM_INT);

			if($delete->execute()) return true;

		} catch(PDOexception $e) {
			return false; #$e->getMessage();
		}
	}

}