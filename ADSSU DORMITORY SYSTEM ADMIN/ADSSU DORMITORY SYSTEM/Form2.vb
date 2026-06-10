Imports System.IO
Imports System.Drawing.Printing
Imports MySql.Data.MySqlClient
Imports BCrypt.Net

Public Class Form2
    Private gridView As DataGridView
    Private activeTab As String = "Dashboard"

    ' Dynamic Dialog Field Structure
    Public Class DialogField
        Public Property Name As String
        Public Property Label As String
        Public Property FieldType As String ' "text", "number", "dropdown", "date", "textarea"
        Public Property Options As String()
        Public Property DefaultValue As String

        Public Sub New(name As String, label As String, fieldType As String, Optional options As String() = Nothing, Optional defaultValue As String = "")
            Me.Name = name
            Me.Label = label
            Me.FieldType = fieldType
            Me.Options = options
            Me.DefaultValue = defaultValue
        End Sub
    

End Class

    Private Sub Form2_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        ' Style Form and Sidebar Buttons
        ResetSidebarButtons()
        btnDashboard.BackColor = Color.FromArgb(30, 41, 59)
        btnDashboard.ForeColor = Color.White
        
        ' Style Cards
        StyleDashboardCard(PanelCardStudents, Color.FromArgb(79, 70, 229))
        StyleDashboardCard(PanelCardRooms, Color.FromArgb(16, 185, 129))
        StyleDashboardCard(PanelCardIncidents, Color.FromArgb(239, 68, 68))

        ' Initialize DataGridView dynamically inside PanelMain
        gridView = New DataGridView()
        gridView.Dock = DockStyle.Fill
        gridView.BackgroundColor = Color.White
        gridView.Visible = False
        gridView.AllowUserToAddRows = False
        gridView.ReadOnly = True
        gridView.AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill
        
        ' UI ENHANCEMENTS FOR DATAGRIDVIEW (Enterprise SaaS Aesthetics)
        gridView.BorderStyle = BorderStyle.None
        gridView.CellBorderStyle = DataGridViewCellBorderStyle.SingleHorizontal
        gridView.DefaultCellStyle.SelectionBackColor = Color.FromArgb(99, 102, 241) ' Indigo 500
        gridView.DefaultCellStyle.SelectionForeColor = Color.White
        gridView.DefaultCellStyle.Font = New Font("Segoe UI", 9.5F)
        gridView.RowHeadersVisible = False
        gridView.EnableHeadersVisualStyles = False
        gridView.GridColor = Color.FromArgb(241, 245, 249)
        gridView.ColumnHeadersBorderStyle = DataGridViewHeaderBorderStyle.None
        gridView.ColumnHeadersDefaultCellStyle.BackColor = Color.FromArgb(15, 23, 42) ' Slate 900
        gridView.ColumnHeadersDefaultCellStyle.ForeColor = Color.White
        gridView.ColumnHeadersDefaultCellStyle.Font = New Font("Segoe UI Semibold", 10F, FontStyle.Bold)
        gridView.ColumnHeadersHeight = 45
        gridView.RowTemplate.Height = 42
        gridView.AlternatingRowsDefaultCellStyle.BackColor = Color.FromArgb(248, 250, 252) ' Slate 50
        gridView.SelectionMode = DataGridViewSelectionMode.FullRowSelect
        gridView.Cursor = Cursors.Hand

        PanelMain.Controls.Add(gridView)
        gridView.BringToFront()

        ' Enable Hand Cursors for Buttons
        For Each ctrl As Control In PanelSidebar.Controls
            If TypeOf ctrl Is Button Then
                ctrl.Cursor = Cursors.Hand
            End If
        Next
        btnAdd.Cursor = Cursors.Hand
        btnEdit.Cursor = Cursors.Hand
        btnDelete.Cursor = Cursors.Hand


        Dim btnExportExcel As New Button() With {
            .Name = "btnExportExcel",
            .Text = "📊  Export to Excel",
            .Width = 150,
            .Height = 35,
            .BackColor = Color.FromArgb(16, 185, 129),
            .ForeColor = Color.White,
            .FlatStyle = FlatStyle.Flat,
            .Font = New Font("Segoe UI Semibold", 9.5F, FontStyle.Bold),
            .Cursor = Cursors.Hand,
            .Anchor = AnchorStyles.Top Or AnchorStyles.Right,
            .Location = New Point(PanelActions.Width - 300, 15)
        }
        btnExportExcel.FlatAppearance.BorderSize = 0
        AddHandler btnExportExcel.Click, AddressOf btnExportExcel_Click

        Dim btnPrintData As New Button() With {
            .Name = "btnPrintData",
            .Text = "🖨️  Print",
            .Width = 100,
            .Height = 35,
            .BackColor = Color.FromArgb(59, 130, 246),
            .ForeColor = Color.White,
            .FlatStyle = FlatStyle.Flat,
            .Font = New Font("Segoe UI Semibold", 9.5F, FontStyle.Bold),
            .Cursor = Cursors.Hand,
            .Anchor = AnchorStyles.Top Or AnchorStyles.Right,
            .Location = New Point(PanelActions.Width - 130, 15)
        }
        btnPrintData.FlatAppearance.BorderSize = 0
        AddHandler btnPrintData.Click, AddressOf btnPrintData_Click

        PanelActions.Controls.Add(btnExportExcel)
        PanelActions.Controls.Add(btnPrintData)

        LoadDashboardData()
    End Sub

    Private Sub StyleDashboardCard(pnl As Panel, accentColor As Color)
        pnl.BackColor = Color.White
        pnl.BorderStyle = BorderStyle.None
        ' Paint left border strip in Load or custom paint event
        AddHandler pnl.Paint, Sub(s, e)
                                  Dim pen As New Pen(accentColor, 6)
                                  e.Graphics.DrawLine(pen, 0, 0, 0, pnl.Height)
                              End Sub
    End Sub

    Private Sub LoadDashboardData()
        activeTab = "Dashboard"
        lblHeaderTitle.Text = "Dashboard Overview"
        PanelDashboardOverview.Visible = True
        gridView.Visible = False
        PanelActions.Visible = False
        
        Dim conn As MySqlConnection = DatabaseConnection.GetConnection()
        If conn Is Nothing Then Return

        Try
            Dim studentsCount As Integer = 0
            Dim roomsCount As Integer = 0
            Dim maintenance_requestsCount As Integer = 0
            
            Dim cmd1 As New MySqlCommand("SELECT COUNT(*) FROM users WHERE role = 'student'", conn)
            studentsCount = Convert.ToInt32(cmd1.ExecuteScalar())
            
            Dim cmd2 As New MySqlCommand("SELECT COUNT(*) FROM dorm_rooms", conn)
            roomsCount = Convert.ToInt32(cmd2.ExecuteScalar())

            Dim cmd3 As New MySqlCommand("SELECT COUNT(*) FROM maintenance_requests WHERE status = 'Pending'", conn)
            maintenance_requestsCount = Convert.ToInt32(cmd3.ExecuteScalar())
            
            lblCardStudentsCount.Text = studentsCount.ToString()
            lblCardRoomsCount.Text = roomsCount.ToString()
            lblCardIncidentsCount.Text = maintenance_requestsCount.ToString()
            lblWelcome.Text = "Welcome back, OSAS Admin! Here is the latest system overview metrics."
        Catch ex As Exception
            lblWelcome.Text = "Error loading metrics: " & ex.Message
        Finally
            conn.Close()
        End Try
    End Sub

    Private Sub ResetSidebarButtons()
        For Each ctrl As Control In PanelSidebar.Controls
            If TypeOf ctrl Is Button Then
                ctrl.BackColor = Color.FromArgb(15, 23, 42)
                ctrl.ForeColor = Color.FromArgb(203, 213, 225)
            End If
        Next
    End Sub

    Private Sub SidebarButton_Click(sender As Object, e As EventArgs) Handles btnDashboard.Click, btnRooms.Click, btnResidents.Click, btnApplications.Click, btnAssignments.Click, btnFees.Click, btnActivities.Click, btnIncidents.Click, btnCleanliness.Click
        Dim btn = CType(sender, Button)
        ResetSidebarButtons()
        btn.BackColor = Color.FromArgb(30, 41, 59)
        btn.ForeColor = Color.White

        Select Case btn.Name
            Case "btnDashboard"
                LoadDashboardData()
            Case "btnRooms"
                ShowGridPanel("Manage Rooms", "SELECT r.id, r.room_number AS `Room Number`, d.name AS `Dormitory`, r.capacity AS `Capacity`, r.current_occupancy AS `Occupancy` FROM dorm_rooms r JOIN dormitories d ON r.dorm_id = d.id")
            Case "btnResidents"
                ShowGridPanel("Manage Residents", "SELECT u.id, u.name AS `Full Name`, u.email AS `Email`, p.student_id_number AS `Student ID`, p.course AS `Course`, p.year_level AS `Year`, p.income_bracket AS `Income Bracket`, IF(p.is_indigenous, 'Yes', 'No') AS `IP Group` FROM users u JOIN residents p ON u.id = p.user_id WHERE u.role = 'student'")
            Case "btnApplications"
                ShowGridPanel("Manage Applications", "SELECT a.id, u.name AS `Student Name`, a.semester AS `Semester`, a.status AS `Status`, a.priority_score AS `Priority Score`, a.created_at AS `Date Applied` FROM applications a JOIN users u ON a.student_id = u.id ORDER BY a.priority_score DESC")
            Case "btnAssignments"
                ShowGridPanel("Room Assignments", "SELECT ra.id, u.name AS `Student Name`, r.room_number AS `Room`, d.name AS `Dormitory`, ra.semester AS `Semester`, ra.check_in_date AS `Check-In`, ra.check_out_date AS `Check-Out` FROM room_assignments ra JOIN users u ON ra.student_id = u.id JOIN dorm_rooms r ON ra.room_id = r.id JOIN dormitories d ON r.dorm_id = d.id")
            Case "btnFees"
                ShowGridPanel("Manage Fees", "SELECT f.id, u.name AS `Student Name`, f.description AS `Description`, f.amount AS `Amount (PHP)`, f.status AS `Status`, f.due_date AS `Due Date`, f.paid_date AS `Paid Date` FROM payments f JOIN users u ON f.student_id = u.id")
            Case "btnActivities"
                ShowGridPanel("Manage Activities", "SELECT id, title AS `Title`, description AS `Description`, activity_date AS `Date Scheduled` FROM activities ORDER BY activity_date DESC")
            Case "btnIncidents"
                ShowGridPanel("Manage Incidents", "SELECT i.id, u.name AS `Resident`, i.issue_title AS `Title`, i.description AS `Details`, i.status AS `Status`, i.assigned_staff AS `Assigned Staff`, i.created_at AS `Date Reported` FROM maintenance_requests i JOIN users u ON i.student_id = u.id")
            Case "btnCleanliness"
                ShowGridPanel("Cleanliness Logs", "SELECT c.id, d.name AS `Dormitory`, c.status AS `Cleanliness Rating`, c.remarks AS `Detailed Remarks`, s.name AS `Logged By`, c.log_date AS `Date Logged` FROM cleanliness_logs c JOIN dormitories d ON c.dorm_id = d.id JOIN users s ON c.logged_by = s.id")
        End Select
    End Sub

    Private Sub ShowGridPanel(title As String, query As String)
        activeTab = title
        lblHeaderTitle.Text = title
        PanelDashboardOverview.Visible = False
        gridView.Visible = True
        PanelActions.Visible = True
        
        ' Configure standard actions label
        btnAdd.Text = "➕  Add " & title.Replace("Manage ", "").Replace("Assignments", "Assignment")
        btnEdit.Text = "✏️  Edit Selected"
        btnDelete.Text = "❌  Delete Selected"

        ' Disable Add for logs if needed, but keep editable for full CRUD
        If title = "Cleanliness Logs" Then
            btnAdd.Text = "➕  Log Inspection"
        End If

        LoadGridData(query)
    End Sub

    Private Sub LoadGridData(query As String)
        Dim conn As MySqlConnection = DatabaseConnection.GetConnection()
        If conn Is Nothing Then Return

        Try
            Dim adapter As New MySqlDataAdapter(query, conn)
            Dim table As New DataTable()
            adapter.Fill(table)
            gridView.DataSource = table
        Catch ex As Exception
            MessageBox.Show("Error loading records: " & ex.Message, "Database Error", MessageBoxButtons.OK, MessageBoxIcon.Error)
        Finally
            conn.Close()
        End Try
    End Sub

    ' Dynamic dialog generator engine (Extremely clean & premium UI)
    Private Function ShowCustomDialog(title As String, fields As List(Of DialogField)) As Dictionary(Of String, String)
        Dim frm As New Form() With {
            .Text = title,
            .Size = New Size(500, 150 + fields.Count * 55),
            .StartPosition = FormStartPosition.CenterParent,
            .FormBorderStyle = FormBorderStyle.FixedDialog,
            .MaximizeBox = False,
            .MinimizeBox = False,
            .BackColor = Color.FromArgb(248, 250, 252) ' Slate 50
        }
        
        Dim controls As New Dictionary(Of String, Control)()
        Dim yPos As Integer = 20
        
        For Each f In fields
            Dim lbl As New Label() With {
                .Text = f.Label,
                .Location = New Point(25, yPos),
                .Width = 150,
                .Font = New Font("Segoe UI Semibold", 9.5F, FontStyle.Bold),
                .ForeColor = Color.FromArgb(71, 85, 105),
                .TextAlign = ContentAlignment.MiddleLeft
            }
            frm.Controls.Add(lbl)
            
            Dim inputCtrl As Control = Nothing
            
            If f.FieldType = "dropdown" Then
                Dim cb As New ComboBox() With {
                    .Location = New Point(180, yPos - 2),
                    .Width = 270,
                    .DropDownStyle = ComboBoxStyle.DropDownList,
                    .Font = New Font("Segoe UI", 10F)
                }
                If f.Options IsNot Nothing Then
                    cb.Items.AddRange(f.Options)
                    If Not String.IsNullOrEmpty(f.DefaultValue) Then
                        cb.SelectedItem = f.DefaultValue
                    ElseIf cb.Items.Count > 0 Then
                        cb.SelectedIndex = 0
                    End If
                End If
                inputCtrl = cb
            ElseIf f.FieldType = "date" Then
                Dim dp As New DateTimePicker() With {
                    .Location = New Point(180, yPos - 2),
                    .Width = 270,
                    .Format = DateTimePickerFormat.Custom,
                    .CustomFormat = "yyyy-MM-dd",
                    .Font = New Font("Segoe UI", 10F)
                }
                If Not String.IsNullOrEmpty(f.DefaultValue) Then
                    Dim dVal As DateTime
                    If DateTime.TryParse(f.DefaultValue, dVal) Then
                        dp.Value = dVal
                    End If
                End If
                inputCtrl = dp
            ElseIf f.FieldType = "textarea" Then
                Dim tb As New TextBox() With {
                    .Location = New Point(180, yPos - 2),
                    .Width = 270,
                    .Multiline = True,
                    .Height = 80,
                    .Text = f.DefaultValue,
                    .Font = New Font("Segoe UI", 10F),
                    .ScrollBars = ScrollBars.Vertical
                }
                inputCtrl = tb
                yPos += 50 ' Give textarea extra space
            Else
                Dim tb As New TextBox() With {
                    .Location = New Point(180, yPos - 2),
                    .Width = 270,
                    .Text = f.DefaultValue,
                    .Font = New Font("Segoe UI", 10F)
                }
                inputCtrl = tb
            End If
            
            frm.Controls.Add(inputCtrl)
            controls.Add(f.Name, inputCtrl)
            
            yPos += 50
        Next
        
        Dim btnOk As New Button() With {
            .Text = "✓ Save Record",
            .DialogResult = DialogResult.OK,
            .Location = New Point(210, yPos + 15),
            .Width = 115,
            .Height = 38,
            .BackColor = Color.FromArgb(79, 70, 229), ' Indigo 600
            .ForeColor = Color.White,
            .FlatStyle = FlatStyle.Flat,
            .Font = New Font("Segoe UI Semibold", 9.5F, FontStyle.Bold),
            .Cursor = Cursors.Hand
        }
        btnOk.FlatAppearance.BorderSize = 0

        Dim btnCancel As New Button() With {
            .Text = "Cancel",
            .DialogResult = DialogResult.Cancel,
            .Location = New Point(335, yPos + 15),
            .Width = 115,
            .Height = 38,
            .BackColor = Color.FromArgb(226, 232, 240),
            .ForeColor = Color.FromArgb(71, 85, 105),
            .FlatStyle = FlatStyle.Flat,
            .Font = New Font("Segoe UI Semibold", 9.5F, FontStyle.Bold),
            .Cursor = Cursors.Hand
        }
        btnCancel.FlatAppearance.BorderSize = 0
        
        frm.Controls.Add(btnOk)
        frm.Controls.Add(btnCancel)
        frm.AcceptButton = btnOk
        frm.CancelButton = btnCancel
        
        If frm.ShowDialog() = DialogResult.OK Then
            Dim results As New Dictionary(Of String, String)()
            For Each pair In controls
                If TypeOf pair.Value Is ComboBox Then
                    Dim val = CType(pair.Value, ComboBox).SelectedItem
                    results.Add(pair.Key, If(val IsNot Nothing, val.ToString(), ""))
                ElseIf TypeOf pair.Value Is DateTimePicker Then
                    results.Add(pair.Key, CType(pair.Value, DateTimePicker).Value.ToString("yyyy-MM-dd"))
                Else
                    results.Add(pair.Key, pair.Value.Text.Trim())
                End If
            Next
            Return results
        End If
        Return Nothing
    End Function

    ' SQL Fetch Helper for Dropdowns
    Private Function FetchColumnData(query As String) As String()
        Dim list As New List(Of String)()
        Dim conn As MySqlConnection = DatabaseConnection.GetConnection()
        If conn Is Nothing Then Return list.ToArray()
        Try
            Using cmd As New MySqlCommand(query, conn)
                Using reader As MySqlDataReader = cmd.ExecuteReader()
                    While reader.Read()
                        list.Add(reader(0).ToString())
                    End While
                End Using
            End Using
        Catch ex As Exception
            ' Fail silently or return empty array
        Finally
            conn.Close()
        End Try
        Return list.ToArray()
    End Function

    ' Execute Query updates safely
    Private Function ExecuteUpdate(query As String, params As Dictionary(Of String, Object)) As Boolean
        Dim conn As MySqlConnection = DatabaseConnection.GetConnection()
        If conn Is Nothing Then Return False
        Try
            Dim cmd As New MySqlCommand(query, conn)
            For Each p In params
                cmd.Parameters.AddWithValue(p.Key, p.Value)
            Next
            cmd.ExecuteNonQuery()
            Return True
        Catch ex As Exception
            MessageBox.Show("Database Error: " & ex.Message, "SQL Error", MessageBoxButtons.OK, MessageBoxIcon.Error)
            Return False
        Finally
            conn.Close()
        End Try
    End Function

    ' CREATE (Add Record) Handler
    Private Sub btnAdd_Click(sender As Object, e As EventArgs) Handles btnAdd.Click
        Select Case activeTab
            Case "Manage Rooms"
                Dim dorms = FetchColumnData("SELECT CONCAT(id, ' - ', name) FROM dormitories")
                Dim fields As New List(Of DialogField) From {
                    New DialogField("dorm", "Select Dormitory", "dropdown", dorms),
                    New DialogField("num", "Room Number", "text"),
                    New DialogField("cap", "Capacity", "number", Nothing, "4")
                }
                Dim res = ShowCustomDialog("Add Room", fields)
                If res IsNot Nothing Then
                    Dim dormId = res("dorm").Split(" "c)(0)
                    ExecuteUpdate("INSERT INTO dorm_rooms (dorm_id, room_number, capacity, current_occupancy) VALUES (@did, @num, @cap, 0)",
                        New Dictionary(Of String, Object) From {{"@did", dormId}, {"@num", res("num")}, {"@cap", res("cap")}})
                    btnRooms.PerformClick()
                End If

            Case "Manage Residents"
                Dim fields As New List(Of DialogField) From {
                    New DialogField("name", "Full Name", "text"),
                    New DialogField("email", "Email Address", "text"),
                    New DialogField("pass", "Password", "text", Nothing, "password"),
                    New DialogField("stud_id", "Student ID", "text"),
                    New DialogField("course", "Course", "text"),
                    New DialogField("year", "Year Level", "dropdown", {"1", "2", "3", "4", "5"}),
                    New DialogField("income", "Income Bracket", "dropdown", {"Low", "Middle", "High"}),
                    New DialogField("ip", "Indigenous Group", "dropdown", {"No", "Yes"})
                }
                Dim res = ShowCustomDialog("Add Resident student", fields)
                If res IsNot Nothing Then
                    Dim conn As MySqlConnection = DatabaseConnection.GetConnection()
                    If conn Is Nothing Then Return
                    Try
                        ' Insert into users, then residents
                        Dim passHash = BCrypt.Net.BCrypt.HashPassword(res("pass"))
                        Dim cmd1 As New MySqlCommand("INSERT INTO users (name, email, password_hash, role) VALUES (@name, @email, @pass, 'student')", conn)
                        cmd1.Parameters.AddWithValue("@name", res("name"))
                        cmd1.Parameters.AddWithValue("@email", res("email"))
                        cmd1.Parameters.AddWithValue("@pass", passHash)
                        cmd1.ExecuteNonQuery()
                        
                        Dim userId As Integer = Convert.ToInt32(cmd1.LastInsertedId)
                        Dim isIp As Boolean = (res("ip") = "Yes")
                        
                        Dim cmd2 As New MySqlCommand("INSERT INTO residents (user_id, student_id_number, course, year_level, income_bracket, is_indigenous) VALUES (@uid, @sid, @crs, @yr, @inc, @ip)", conn)
                        cmd2.Parameters.AddWithValue("@uid", userId)
                        cmd2.Parameters.AddWithValue("@sid", res("stud_id"))
                        cmd2.Parameters.AddWithValue("@crs", res("course"))
                        cmd2.Parameters.AddWithValue("@yr", res("year"))
                        cmd2.Parameters.AddWithValue("@inc", res("income"))
                        cmd2.Parameters.AddWithValue("@ip", isIp)
                        cmd2.ExecuteNonQuery()
                        
                        MessageBox.Show("Student resident profile added successfully!")
                    Catch ex As Exception
                        MessageBox.Show("Error inserting resident: " & ex.Message)
                    Finally
                        conn.Close()
                    End Try
                    btnResidents.PerformClick()
                End If

            Case "Manage Applications"
                Dim students = FetchColumnData("SELECT CONCAT(id, ' - ', name) FROM users WHERE role = 'student'")
                Dim fields As New List(Of DialogField) From {
                    New DialogField("stud", "Select Student", "dropdown", students),
                    New DialogField("sem", "Semester", "dropdown", {"1st Semester 2026-2027", "2nd Semester 2026-2027", "Summer 2026"}),
                    New DialogField("status", "Status", "dropdown", {"Pending", "Approved", "Rejected"}),
                    New DialogField("score", "Priority Score", "number", Nothing, "10")
                }
                Dim res = ShowCustomDialog("Add Application", fields)
                If res IsNot Nothing Then
                    Dim studId = res("stud").Split(" "c)(0)
                    ExecuteUpdate("INSERT INTO applications (student_id, semester, status, priority_score) VALUES (@sid, @sem, @status, @score)",
                        New Dictionary(Of String, Object) From {{"@sid", studId}, {"@sem", res("sem")}, {"@status", res("status")}, {"@score", res("score")}})
                    btnApplications.PerformClick()
                End If

            Case "Room Assignments"
                Dim students = FetchColumnData("SELECT CONCAT(id, ' - ', name) FROM users WHERE role = 'student'")
                Dim rooms = FetchColumnData("SELECT CONCAT(id, ' - ', room_number, ' (Dorm ', dorm_id, ')') FROM dorm_rooms WHERE current_occupancy < capacity")
                Dim fields As New List(Of DialogField) From {
                    New DialogField("stud", "Select Student", "dropdown", students),
                    New DialogField("room", "Select Room", "dropdown", rooms),
                    New DialogField("sem", "Semester", "text", Nothing, "1st Semester 2026-2027"),
                    New DialogField("check_in", "Check-In Date", "date")
                }
                Dim res = ShowCustomDialog("Assign Room", fields)
                If res IsNot Nothing Then
                    Dim studId = res("stud").Split(" "c)(0)
                    Dim roomId = res("room").Split(" "c)(0)
                    
                    ' Update occupancy & insert assignment
                    ExecuteUpdate("INSERT INTO room_assignments (student_id, room_id, semester, check_in_date) VALUES (@sid, @rid, @sem, @chk)",
                        New Dictionary(Of String, Object) From {{"@sid", studId}, {"@rid", roomId}, {"@sem", res("sem")}, {"@chk", res("check_in")}})
                    ExecuteUpdate("UPDATE dorm_rooms SET current_occupancy = current_occupancy + 1 WHERE id = @rid", New Dictionary(Of String, Object) From {{"@rid", roomId}})
                    btnAssignments.PerformClick()
                End If

            Case "Manage Fees"
                Dim students = FetchColumnData("SELECT CONCAT(id, ' - ', name) FROM users WHERE role = 'student'")
                Dim fields As New List(Of DialogField) From {
                    New DialogField("stud", "Select Student", "dropdown", students),
                    New DialogField("amt", "Amount (PHP)", "number"),
                    New DialogField("desc", "Description", "text"),
                    New DialogField("status", "Status", "dropdown", {"Unpaid", "Paid"}),
                    New DialogField("due", "Due Date", "date")
                }
                Dim res = ShowCustomDialog("Create Fee Charge", fields)
                If res IsNot Nothing Then
                    Dim studId = res("stud").Split(" "c)(0)
                    Dim pdDate As Object = DBNull.Value
                    If res("status") = "Paid" Then pdDate = DateTime.Now.ToString("yyyy-MM-dd")
                    ExecuteUpdate("INSERT INTO payments (student_id, amount, description, status, due_date, paid_date) VALUES (@sid, @amt, @desc, @status, @due, @pd)",
                        New Dictionary(Of String, Object) From {{"@sid", studId}, {"@amt", res("amt")}, {"@desc", res("desc")}, {"@status", res("status")}, {"@due", res("due")}, {"@pd", pdDate}})
                    btnFees.PerformClick()
                End If

            Case "Manage Activities"
                Dim fields As New List(Of DialogField) From {
                    New DialogField("title", "Activity Title", "text"),
                    New DialogField("desc", "Description", "textarea"),
                    New DialogField("date", "Scheduled Date", "date")
                }
                Dim res = ShowCustomDialog("Create Activity", fields)
                If res IsNot Nothing Then
                    ExecuteUpdate("INSERT INTO activities (title, description, activity_date, created_by) VALUES (@title, @desc, @date, 1)",
                        New Dictionary(Of String, Object) From {{"@title", res("title")}, {"@desc", res("desc")}, {"@date", res("date")}})
                    btnActivities.PerformClick()
                End If

            Case "Manage Incidents"
                Dim students = FetchColumnData("SELECT CONCAT(id, ' - ', name) FROM users WHERE role = 'student'")
                Dim sups = FetchColumnData("SELECT name FROM users WHERE role = 'supervisor'")
                Dim fields As New List(Of DialogField) From {
                    New DialogField("stud", "Resident Student", "dropdown", students),
                    New DialogField("title", "Incident Title", "text"),
                    New DialogField("desc", "Incident Details", "textarea"),
                    New DialogField("status", "Status", "dropdown", {"Pending", "Assigned", "Resolved"}),
                    New DialogField("sup", "Assigned Staff", "dropdown", sups)
                }
                Dim res = ShowCustomDialog("Report Incident", fields)
                If res IsNot Nothing Then
                    Dim studId = res("stud").Split(" "c)(0)
                    Dim staffName = res("sup")
                    ExecuteUpdate("INSERT INTO maintenance_requests (student_id, issue_title, description, status, assigned_staff) VALUES (@sid, @title, @desc, @status, @log)",
                        New Dictionary(Of String, Object) From {{"@sid", studId}, {"@title", res("title")}, {"@desc", res("desc")}, {"@status", res("status")}, {"@log", staffName}})
                    btnIncidents.PerformClick()
                End If

            Case "Cleanliness Logs"
                Dim dorms = FetchColumnData("SELECT CONCAT(id, ' - ', name) FROM dormitories")
                Dim sups = FetchColumnData("SELECT CONCAT(id, ' - ', name) FROM users WHERE role = 'supervisor'")
                Dim fields As New List(Of DialogField) From {
                    New DialogField("dorm", "Dormitory", "dropdown", dorms),
                    New DialogField("sup", "Logged By", "dropdown", sups),
                    New DialogField("status", "Cleanliness Rating", "dropdown", {"Excellent", "Good", "Fair", "Poor"}),
                    New DialogField("remarks", "Remarks", "textarea"),
                    New DialogField("date", "Log Date", "date")
                }
                Dim res = ShowCustomDialog("Log Cleanliness Check", fields)
                If res IsNot Nothing Then
                    Dim dormId = res("dorm").Split(" "c)(0)
                    Dim supId = res("sup").Split(" "c)(0)
                    ExecuteUpdate("INSERT INTO cleanliness_logs (dorm_id, logged_by, status, remarks, log_date) VALUES (@did, @uid, @status, @rem, @date)",
                        New Dictionary(Of String, Object) From {{"@did", dormId}, {"@uid", supId}, {"@status", res("status")}, {"@rem", res("remarks")}, {"@date", res("date")}})
                    btnCleanliness.PerformClick()
                End If
        End Select
    End Sub

    ' UPDATE (Edit Selected Record) Handler
    Private Sub btnEdit_Click(sender As Object, e As EventArgs) Handles btnEdit.Click
        If gridView.SelectedRows.Count = 0 Then
            MessageBox.Show("Please select a row to modify.", "No Selection", MessageBoxButtons.OK, MessageBoxIcon.Warning)
            Return
        End If
        
        Dim selectedRow = gridView.SelectedRows(0)
        Dim recId As Integer = Convert.ToInt32(selectedRow.Cells(0).Value)

        Select Case activeTab
            Case "Manage Rooms"
                Dim dorms = FetchColumnData("SELECT CONCAT(id, ' - ', name) FROM dormitories")
                Dim fields As New List(Of DialogField) From {
                    New DialogField("dorm", "Select Dormitory", "dropdown", dorms, selectedRow.Cells("Dormitory").Value.ToString()),
                    New DialogField("num", "Room Number", "text", Nothing, selectedRow.Cells("Room Number").Value.ToString()),
                    New DialogField("cap", "Capacity", "number", Nothing, selectedRow.Cells("Capacity").Value.ToString())
                }
                Dim res = ShowCustomDialog("Edit Room Details", fields)
                If res IsNot Nothing Then
                    Dim dormId = res("dorm").Split(" "c)(0)
                    ExecuteUpdate("UPDATE dorm_rooms SET dorm_id = @did, room_number = @num, capacity = @cap WHERE id = @rid",
                        New Dictionary(Of String, Object) From {{"@did", dormId}, {"@num", res("num")}, {"@cap", res("cap")}, {"@rid", recId}})
                    btnRooms.PerformClick()
                End If

            Case "Manage Residents"
                ' Fetch password hashing values or simply fields
                Dim fields As New List(Of DialogField) From {
                    New DialogField("name", "Full Name", "text", Nothing, selectedRow.Cells("Full Name").Value.ToString()),
                    New DialogField("email", "Email Address", "text", Nothing, selectedRow.Cells("Email").Value.ToString()),
                    New DialogField("stud_id", "Student ID", "text", Nothing, selectedRow.Cells("Student ID").Value.ToString()),
                    New DialogField("course", "Course", "text", Nothing, selectedRow.Cells("Course").Value.ToString()),
                    New DialogField("year", "Year Level", "dropdown", {"1", "2", "3", "4", "5"}, selectedRow.Cells("Year").Value.ToString()),
                    New DialogField("income", "Income Bracket", "dropdown", {"Low", "Middle", "High"}, selectedRow.Cells("Income Bracket").Value.ToString()),
                    New DialogField("ip", "Indigenous Group", "dropdown", {"No", "Yes"}, selectedRow.Cells("IP Group").Value.ToString())
                }
                Dim res = ShowCustomDialog("Edit Resident student", fields)
                If res IsNot Nothing Then
                    Dim conn As MySqlConnection = DatabaseConnection.GetConnection()
                    If conn Is Nothing Then Return
                    Try
                        ' Update users, then residents
                        Dim cmd1 As New MySqlCommand("UPDATE users SET name = @name, email = @email WHERE id = @uid", conn)
                        cmd1.Parameters.AddWithValue("@name", res("name"))
                        cmd1.Parameters.AddWithValue("@email", res("email"))
                        cmd1.Parameters.AddWithValue("@uid", recId)
                        cmd1.ExecuteNonQuery()
                        
                        Dim isIp As Boolean = (res("ip") = "Yes")
                        Dim cmd2 As New MySqlCommand("UPDATE residents SET student_id_number = @sid, course = @crs, year_level = @yr, income_bracket = @inc, is_indigenous = @ip WHERE user_id = @uid", conn)
                        cmd2.Parameters.AddWithValue("@uid", recId)
                        cmd2.Parameters.AddWithValue("@sid", res("stud_id"))
                        cmd2.Parameters.AddWithValue("@crs", res("course"))
                        cmd2.Parameters.AddWithValue("@yr", res("year"))
                        cmd2.Parameters.AddWithValue("@inc", res("income"))
                        cmd2.Parameters.AddWithValue("@ip", isIp)
                        cmd2.ExecuteNonQuery()
                        
                        MessageBox.Show("Student resident profile updated successfully!")
                    Catch ex As Exception
                        MessageBox.Show("Error updating profile: " & ex.Message)
                    Finally
                        conn.Close()
                    End Try
                    btnResidents.PerformClick()
                End If

            Case "Manage Applications"
                Dim fields As New List(Of DialogField) From {
                    New DialogField("sem", "Semester", "dropdown", {"1st Semester 2026-2027", "2nd Semester 2026-2027", "Summer 2026"}, selectedRow.Cells("Semester").Value.ToString()),
                    New DialogField("status", "Status", "dropdown", {"Pending", "Approved", "Rejected"}, selectedRow.Cells("Status").Value.ToString()),
                    New DialogField("score", "Priority Score", "number", Nothing, selectedRow.Cells("Priority Score").Value.ToString())
                }
                Dim res = ShowCustomDialog("Edit Application", fields)
                If res IsNot Nothing Then
                    ExecuteUpdate("UPDATE applications SET semester = @sem, status = @status, priority_score = @score WHERE id = @aid",
                        New Dictionary(Of String, Object) From {{"@sem", res("sem")}, {"@status", res("status")}, {"@score", res("score")}, {"@aid", recId}})
                    btnApplications.PerformClick()
                End If

            Case "Room Assignments"
                Dim fields As New List(Of DialogField) From {
                    New DialogField("sem", "Semester", "text", Nothing, selectedRow.Cells("Semester").Value.ToString()),
                    New DialogField("check_in", "Check-In Date", "date", Nothing, selectedRow.Cells("Check-In").Value.ToString()),
                    New DialogField("check_out", "Check-Out Date", "date", Nothing, If(selectedRow.Cells("Check-Out").Value Is DBNull.Value, DateTime.Now.ToString("yyyy-MM-dd"), selectedRow.Cells("Check-Out").Value.ToString()))
                }
                Dim res = ShowCustomDialog("Edit Assignment", fields)
                If res IsNot Nothing Then
                    ExecuteUpdate("UPDATE room_assignments SET semester = @sem, check_in_date = @chk, check_out_date = @out WHERE id = @raid",
                        New Dictionary(Of String, Object) From {{"@sem", res("sem")}, {"@chk", res("check_in")}, {"@out", res("check_out")}, {"@raid", recId}})
                    btnAssignments.PerformClick()
                End If

            Case "Manage Fees"
                Dim fields As New List(Of DialogField) From {
                    New DialogField("amt", "Amount (PHP)", "number", Nothing, selectedRow.Cells("Amount (PHP)").Value.ToString()),
                    New DialogField("desc", "Description", "text", Nothing, selectedRow.Cells("Description").Value.ToString()),
                    New DialogField("status", "Status", "dropdown", {"Unpaid", "Paid"}, selectedRow.Cells("Status").Value.ToString()),
                    New DialogField("due", "Due Date", "date", Nothing, selectedRow.Cells("Due Date").Value.ToString())
                }
                Dim res = ShowCustomDialog("Edit Fee Details", fields)
                If res IsNot Nothing Then
                    ExecuteUpdate("UPDATE payments SET amount = @amt, description = @desc, status = @status, due_date = @due, paid_date = CASE WHEN @status = 'Unpaid' THEN NULL WHEN paid_date IS NULL THEN CURRENT_DATE() ELSE paid_date END WHERE id = @fid",
                        New Dictionary(Of String, Object) From {{"@amt", res("amt")}, {"@desc", res("desc")}, {"@status", res("status")}, {"@due", res("due")}, {"@fid", recId}})
                    btnFees.PerformClick()
                End If

            Case "Manage Activities"
                Dim fields As New List(Of DialogField) From {
                    New DialogField("title", "Activity Title", "text", Nothing, selectedRow.Cells("Title").Value.ToString()),
                    New DialogField("desc", "Description", "textarea", Nothing, selectedRow.Cells("Description").Value.ToString()),
                    New DialogField("date", "Scheduled Date", "date", Nothing, selectedRow.Cells("Date Scheduled").Value.ToString())
                }
                Dim res = ShowCustomDialog("Edit Activity Details", fields)
                If res IsNot Nothing Then
                    ExecuteUpdate("UPDATE activities SET title = @title, description = @desc, activity_date = @date WHERE id = @aid",
                        New Dictionary(Of String, Object) From {{"@title", res("title")}, {"@desc", res("desc")}, {"@date", res("date")}, {"@aid", recId}})
                    btnActivities.PerformClick()
                End If

            Case "Manage Incidents"
                Dim sups = FetchColumnData("SELECT name FROM users WHERE role = 'supervisor'")
                Dim currentStaff = ""
                If selectedRow.Cells("Assigned Staff").Value IsNot DBNull.Value AndAlso selectedRow.Cells("Assigned Staff").Value IsNot Nothing Then
                    currentStaff = selectedRow.Cells("Assigned Staff").Value.ToString()
                End If
                Dim fields As New List(Of DialogField) From {
                    New DialogField("title", "Incident Title", "text", Nothing, selectedRow.Cells("Title").Value.ToString()),
                    New DialogField("desc", "Incident Details", "textarea", Nothing, selectedRow.Cells("Details").Value.ToString()),
                    New DialogField("status", "Status", "dropdown", {"Pending", "Assigned", "Resolved"}, selectedRow.Cells("Status").Value.ToString()),
                    New DialogField("staff", "Assigned Staff", "dropdown", sups.ToArray(), currentStaff)
                }
                Dim res = ShowCustomDialog("Resolve Incident Report", fields)
                If res IsNot Nothing Then
                    ExecuteUpdate("UPDATE maintenance_requests SET issue_title = @title, description = @desc, status = @status, assigned_staff = @staff WHERE id = @iid",
                        New Dictionary(Of String, Object) From {{"@title", res("title")}, {"@desc", res("desc")}, {"@status", res("status")}, {"@staff", res("staff")}, {"@iid", recId}})
                    btnIncidents.PerformClick()
                End If

            Case "Cleanliness Logs"
                Dim fields As New List(Of DialogField) From {
                    New DialogField("status", "Cleanliness Grade", "dropdown", {"Excellent", "Good", "Fair", "Poor"}, selectedRow.Cells("Cleanliness Rating").Value.ToString()),
                    New DialogField("remarks", "Remarks", "textarea", Nothing, selectedRow.Cells("Detailed Remarks").Value.ToString())
                }
                Dim res = ShowCustomDialog("Edit Cleanliness Log", fields)
                If res IsNot Nothing Then
                    ExecuteUpdate("UPDATE cleanliness_logs SET status = @status, remarks = @rem WHERE id = @cid",
                        New Dictionary(Of String, Object) From {{"@status", res("status")}, {"@rem", res("remarks")}, {"@cid", recId}})
                    btnCleanliness.PerformClick()
                End If
        End Select
    End Sub

    ' DELETE (Delete Selected Record) Handler
    Private Sub btnDelete_Click(sender As Object, e As EventArgs) Handles btnDelete.Click
        If gridView.SelectedRows.Count = 0 Then
            MessageBox.Show("Please select a row to delete.", "No Selection", MessageBoxButtons.OK, MessageBoxIcon.Warning)
            Return
        End If
        
        Dim result = MessageBox.Show("Are you sure you want to delete the selected record? This action is irreversible.", "Confirm Deletion", MessageBoxButtons.YesNo, MessageBoxIcon.Question)
        If result = DialogResult.Yes Then
            Dim selectedRow = gridView.SelectedRows(0)
            Dim recId As Integer = Convert.ToInt32(selectedRow.Cells(0).Value)
            Dim table As String = ""
            
            Select Case activeTab
                Case "Manage Rooms" : table = "rooms"
                Case "Manage Residents" : table = "users" ' Cascades to student profiles automatically
                Case "Manage Applications" : table = "applications"
                Case "Room Assignments"
                    table = "room_assignments"
                    ' Decrement room occupancy first
                    Dim roomId = FetchColumnData($"SELECT room_id FROM room_assignments WHERE id = {recId}")
                    If roomId.Count > 0 Then
                        ExecuteUpdate("UPDATE dorm_rooms SET current_occupancy = current_occupancy - 1 WHERE id = @rid", New Dictionary(Of String, Object) From {{"@rid", roomId(0)}})
                    End If
                Case "Manage Fees" : table = "payments"
                Case "Manage Activities" : table = "activities"
                Case "Manage Incidents" : table = "maintenance_requests"
                Case "Cleanliness Logs" : table = "cleanliness_logs"
            End Select

            If Not String.IsNullOrEmpty(table) Then
                ExecuteUpdate($"DELETE FROM {table} WHERE id = @id", New Dictionary(Of String, Object) From {{"@id", recId}})
                
                ' Refresh active tab
                Select Case activeTab
                    Case "Manage Rooms" : btnRooms.PerformClick()
                    Case "Manage Residents" : btnResidents.PerformClick()
                    Case "Manage Applications" : btnApplications.PerformClick()
                    Case "Room Assignments" : btnAssignments.PerformClick()
                    Case "Manage Fees" : btnFees.PerformClick()
                    Case "Manage Activities" : btnActivities.PerformClick()
                    Case "Manage Incidents" : btnIncidents.PerformClick()
                    Case "Cleanliness Logs" : btnCleanliness.PerformClick()
                End Select
            End If
        End If
    End Sub

    Private Sub btnLogout_Click(sender As Object, e As EventArgs) Handles btnLogout.Click
        Dim result = MessageBox.Show("Are you sure you want to log out?", "Logout", MessageBoxButtons.YesNo, MessageBoxIcon.Question)
        If result = DialogResult.Yes Then
            Me.Hide()
            Dim loginForm As New Form1()
            loginForm.Show()
        End If
    End Sub

    Private Sub Form2_FormClosed(sender As Object, e As FormClosedEventArgs) Handles MyBase.FormClosed
        Application.Exit()
    End Sub
    Private Sub btnExportExcel_Click(sender As Object, e As EventArgs)
        If gridView.Rows.Count = 0 Then
            MessageBox.Show("No data to export.", "Warning", MessageBoxButtons.OK, MessageBoxIcon.Warning)
            Return
        End If

        Dim sfd As New SaveFileDialog()
        sfd.Filter = "Excel Output (*.xls)|*.xls"
        sfd.FileName = activeTab & " Export.xls"

        If sfd.ShowDialog() = DialogResult.OK Then
            Try
                Dim html As New System.Text.StringBuilder()
                html.AppendLine("<html><head><meta charset=""utf-8""><style>table { border-collapse: collapse; width: 100%; font-family: Arial; } th { background-color: #0f172a; color: white; padding: 10px; border: 1px solid #ccc; text-align: center; } td { padding: 8px; border: 1px solid #ccc; text-align: center; } h2 { color: #0f172a; text-align: center; }</style></head><body>")
                html.AppendLine("<h2>" & activeTab & " - ADSSU Dormitory System</h2>")
                html.AppendLine("<table>")

                ' Headers
                html.AppendLine("<tr>")
                For i As Integer = 0 To gridView.Columns.Count - 1
                    html.AppendLine("<th>" & gridView.Columns(i).HeaderText & "</th>")
                Next
                html.AppendLine("</tr>")

                ' Data Rows
                For Each row As DataGridViewRow In gridView.Rows
                    If Not row.IsNewRow Then
                        html.AppendLine("<tr>")
                        For i As Integer = 0 To gridView.Columns.Count - 1
                            Dim val As String = If(row.Cells(i).Value IsNot Nothing, row.Cells(i).Value.ToString(), "")
                            html.AppendLine("<td>" & val & "</td>")
                        Next
                        html.AppendLine("</tr>")
                    End If
                Next

                html.AppendLine("</table></body></html>")

                File.WriteAllText(sfd.FileName, html.ToString(), System.Text.Encoding.UTF8)
                MessageBox.Show("Data successfully exported to Excel format!", "Export Success", MessageBoxButtons.OK, MessageBoxIcon.Information)
            Catch ex As Exception
                MessageBox.Show("Error exporting: " & ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error)
            End Try
        End If
    End Sub

    Private printDocument As New PrintDocument()
    Private Sub btnPrintData_Click(sender As Object, e As EventArgs)
        If gridView.Rows.Count = 0 Then
            MessageBox.Show("No data to print.", "Warning", MessageBoxButtons.OK, MessageBoxIcon.Warning)
            Return
        End If

        printDocument.DefaultPageSettings.Landscape = True

        RemoveHandler printDocument.PrintPage, AddressOf PrintPage_Handler
        AddHandler printDocument.PrintPage, AddressOf PrintPage_Handler

        Dim printPreviewDialog As New PrintPreviewDialog()
        printPreviewDialog.Document = printDocument
        printPreviewDialog.Width = 800
        printPreviewDialog.Height = 600
        printPreviewDialog.ShowDialog()
    End Sub

    Private Sub PrintPage_Handler(sender As Object, e As PrintPageEventArgs)
        Dim g As Graphics = e.Graphics
        Dim fontHeader As New Font("Segoe UI", 16, FontStyle.Bold)
        Dim fontCol As New Font("Segoe UI", 10, FontStyle.Bold)
        Dim fontRow As New Font("Segoe UI", 9)
        Dim brushBlack As New SolidBrush(Color.Black)
        Dim penLine As New Pen(Color.Gray, 1)
        Dim sf As New StringFormat() With {
            .Alignment = StringAlignment.Center,
            .LineAlignment = StringAlignment.Center
        }

        Dim y As Integer = e.MarginBounds.Top
        Dim startX As Integer = e.MarginBounds.Left

        Dim headerRect As New RectangleF(startX, y, e.MarginBounds.Width, 40)
        g.DrawString(activeTab & " - ADSSU Dormitory System", fontHeader, brushBlack, headerRect, sf)
        y += 40
        g.DrawLine(penLine, startX, y, e.MarginBounds.Right, y)
        y += 10

        Dim colWidths(gridView.Columns.Count - 1) As Integer
        Dim availableWidth As Integer = e.MarginBounds.Width
        Dim totalGridWidth As Integer = 0
        For i As Integer = 0 To gridView.Columns.Count - 1
            totalGridWidth += gridView.Columns(i).Width
        Next
        For i As Integer = 0 To gridView.Columns.Count - 1
            colWidths(i) = CInt((gridView.Columns(i).Width / totalGridWidth) * availableWidth)
        Next

        Dim x As Integer = startX
        For i As Integer = 0 To gridView.Columns.Count - 1
            Dim rect As New RectangleF(x, y, colWidths(i), 30)
            g.DrawString(gridView.Columns(i).HeaderText, fontCol, brushBlack, rect, sf)
            x += colWidths(i)
        Next
        y += 30
        g.DrawLine(penLine, startX, y, e.MarginBounds.Right, y)
        y += 10

        For Each row As DataGridViewRow In gridView.Rows
            If Not row.IsNewRow Then
                Dim maxRowHeight As Single = 30
                For i As Integer = 0 To gridView.Columns.Count - 1
                    Dim val As String = If(row.Cells(i).Value IsNot Nothing, row.Cells(i).Value.ToString(), "")
                    Dim size = g.MeasureString(val, fontRow, colWidths(i), sf)
                    If size.Height > maxRowHeight Then maxRowHeight = size.Height
                Next
                maxRowHeight += 10

                x = startX
                For i As Integer = 0 To gridView.Columns.Count - 1
                    Dim val As String = If(row.Cells(i).Value IsNot Nothing, row.Cells(i).Value.ToString(), "")
                    Dim rect As New RectangleF(x, y, colWidths(i), maxRowHeight)
                    g.DrawString(val, fontRow, brushBlack, rect, sf)
                    x += colWidths(i)
                Next
                y += CInt(maxRowHeight)
                If y > e.MarginBounds.Bottom - CInt(maxRowHeight) Then
                    e.HasMorePages = True
                    Return
                End If
            End If
        Next
        e.HasMorePages = False
    End Sub

End Class
