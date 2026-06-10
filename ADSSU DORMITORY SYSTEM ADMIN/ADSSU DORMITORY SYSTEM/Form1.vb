Imports MySql.Data.MySqlClient
Imports BCrypt.Net

Public Class Form1
    Private Sub btnLogin_Click(sender As Object, e As EventArgs) Handles btnLogin.Click
        Dim email As String = txtUsername.Text.Trim()
        Dim password As String = txtPassword.Text

        If String.IsNullOrEmpty(email) OrElse String.IsNullOrEmpty(password) Then
            MessageBox.Show("Please enter both email and password.", "Validation Error", MessageBoxButtons.OK, MessageBoxIcon.Warning)
            Return
        End If

        Dim conn As MySqlConnection = DatabaseConnection.GetConnection()
        If conn Is Nothing Then Return

        Try
            Dim query As String = "SELECT * FROM users WHERE email = @email AND role = 'admin'"
            Using cmd As New MySqlCommand(query, conn)
                cmd.Parameters.AddWithValue("@email", email)

                Using reader As MySqlDataReader = cmd.ExecuteReader()
                    If reader.Read() Then
                        Dim hash As String = reader("password_hash").ToString()
                        ' Verify the bcrypt hash
                        If BCrypt.Net.BCrypt.Verify(password, hash) Then
                            Dim dashboard As New Form2()
                            dashboard.Show()
                            Me.Hide()
                        Else
                            MessageBox.Show("Invalid password.", "Login Failed", MessageBoxButtons.OK, MessageBoxIcon.Error)
                        End If
                    Else
                        MessageBox.Show("Invalid email or you do not have administrator privileges.", "Login Failed", MessageBoxButtons.OK, MessageBoxIcon.Error)
                    End If
                End Using
            End Using
        Catch ex As Exception
            MessageBox.Show("An error occurred during login: " & ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error)
        Finally
            conn.Close()
        End Try
    End Sub

    Private Sub Form1_Load(sender As Object, e As EventArgs) Handles MyBase.Load
    End Sub

    Private Sub btnLogin_MouseEnter(sender As Object, e As EventArgs) Handles btnLogin.MouseEnter
        btnLogin.BackColor = Color.FromArgb(99, 102, 241)
    End Sub

    Private Sub btnLogin_MouseLeave(sender As Object, e As EventArgs) Handles btnLogin.MouseLeave
        btnLogin.BackColor = Color.FromArgb(79, 70, 229)
    End Sub
End Class
