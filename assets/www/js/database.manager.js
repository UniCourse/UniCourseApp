function openDB(usernumber) {
	var db = openDatabase(
		"uni_" + usernumber,
		"1.0",
		"Database for Unicourse user " + usernumber,
		1024000
	);
	return db;
}

function createTable(db) {
	var sql = 'CREATE TABLE test_table(id INTEGER PRIMARY KEY AUTOINCREMENT, note TEXT, date DATE);'
	db.transaction(function (tx) {
		tx.executeSql(
			sql,
			[],
			function () {
				console.log("success");
			},
			statementErrorCallback
		);
		console.log("execute sql...");
	}, transactionErrorCallback
	);
	console.log("create table...");
}

function statementErrorCallback(error) {
	alert('Error: ' + error.message);
} 

function transactionErrorCallback(error) {
	alert('Error: ' + error.message);
}

function insertRecord(db, record) {
	var sql = "INSERT INTO test_table(note, date) VALUES (?, ?);";
	db.transaction(function (tx) {
		tx.executeSql(
			sql,
			[record.note, record.date],
			function () {
				console.log("insert success");
			},
			statementErrorCallback
		);
	});
}

function getRecords(db) {
	var sql = "SELECT * FROM test_table;";
	db.transaction( function (tx) {
		tx.executeSql(
			sql,
			[],
			function (transaction, resultSet) {
				console.log("get success");
				var rows = resultSet.rows;
				for (var i = 0; i < rows.length; i++) {
					$("#show").append(rows.item(i).note + '<br />');
				}
			},
			statementErrorCallback
		);
	});
}