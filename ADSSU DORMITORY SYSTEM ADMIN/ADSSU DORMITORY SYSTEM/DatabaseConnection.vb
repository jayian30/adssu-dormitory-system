Imports MySql.Data.MySqlClient

Module DatabaseConnection
    ' Connection string for a local MySQL database via XAMPP
    Private Const ConnectionString As String = "Server=127.0.0.1;Port=3307;Database=adssu_dorm_db;User ID=root;Password=;"

    ' Helper method to get an open connection
    Public Function GetConnection() As MySqlConnection
        Dim conn As New MySqlConnection(ConnectionString)
        Try
            conn.Open()
            Return conn
        Catch ex As Exception
            MessageBox.Show("Database connection failed: " & ex.Message, "Connection Error", MessageBoxButtons.OK, MessageBoxIcon.Error)
            Return Nothing
        End Try
    End Function
End Module
