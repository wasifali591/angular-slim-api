<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes


/**
 * get method to fetch data from database
 * full-url: http://localhost/angular-slim-api/public/api/get-employee
 */
$app->get('/api/get-employee', function ($request, $response) {
    $db = $this->get('db');
    $query = "select * from employee";
    $result = $db->query($query);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    return $response->withJSON($data, 200);
});

/**
 * post method to insert data into database
 * full-url: http://localhost/angular-slim-api/public/api/post-employee
 */
$app->post('/api/post-employee', function ($request, $response) {
    $db = $this->get('db');
    $query = "INSERT INTO `employee`(`FullName`,`EmpCode`,`Mobile`,`Position`) VALUES(?,?,?,?)";
    $stmt = $db->prepare($query);
    $FullName = $request->getParsedBody()['FullName'];
    $EmpCode = $request->getParsedBody()['EmpCode'];
    $Mobile = $request->getParsedBody()['Mobile'];
    $Position = $request->getParsedBody()['Position'];
    $data = array($FullName, $EmpCode, $Mobile, $Position);
    $result = $stmt->execute($data);
    return $response->withJSON($result, 201);
});

/**
 * put method to update data into database
 * depending on id passes through the url
 * full-url: http://localhost/angular-slim-api/public/api/put-employee/{id}
 */
$app->put('/api/put-employee/{id}', function ($request, $response) {
    $db = $this->get('db');
    $id = $request->getAttribute('id');
    $query = "UPDATE `employee` SET `FullName` = ?, `EmpCode` = ?, `Mobile` = ?,`Position`=?  WHERE `EmployeeID` = $id";
    $stmt = $db->prepare($query);
    $FullName = $request->getParsedBody()['FullName'];
    $EmpCode = $request->getParsedBody()['EmpCode'];
    $Mobile = $request->getParsedBody()['Mobile'];
    $Position = $request->getParsedBody()['Position'];
    $data = array($FullName, $EmpCode, $Mobile, $Position);
    $result = $stmt->execute($data);
    return $response->withJSON($result, 200);

});

/**
 * delete method to delete data from database
 * depending on id passes through the url
 * full-url: http://localhost/angular-slim-api/public/api/delete-employee/{id}
 */
$app->delete('/api/delete-employee/{id}', function ($request, $response) {
    $db = $this->get('db');
    $id = $request->getAttribute('id');
    $query = "DELETE FROM `employee` WHERE `EmployeeID`='$id'";
    $result = $db->exec($query);
    return $response->withJSON($result, 200);
});
