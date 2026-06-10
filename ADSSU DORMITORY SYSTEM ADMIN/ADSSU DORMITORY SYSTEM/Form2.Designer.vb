<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()>
Partial Class Form2
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()>
    Protected Overrides Sub Dispose(disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()>
    Private Sub InitializeComponent()
        PanelSidebar = New Panel()
        btnLogout = New Button()
        btnCleanliness = New Button()
        btnIncidents = New Button()
        btnActivities = New Button()
        btnFees = New Button()
        btnAssignments = New Button()
        btnApplications = New Button()
        btnResidents = New Button()
        btnRooms = New Button()
        btnDashboard = New Button()
        PanelLogo = New Panel()
        lblLogo = New Label()
        PanelHeader = New Panel()
        lblHeaderTitle = New Label()
        PanelMain = New Panel()
        PanelDashboardOverview = New Panel()
        lblWelcome = New Label()
        PanelCardGrid = New TableLayoutPanel()
        PanelCardStudents = New Panel()
        lblCardStudentsCount = New Label()
        lblCardStudentsTitle = New Label()
        PanelCardRooms = New Panel()
        lblCardRoomsCount = New Label()
        lblCardRoomsTitle = New Label()
        PanelCardIncidents = New Panel()
        lblCardIncidentsCount = New Label()
        lblCardIncidentsTitle = New Label()
        PanelActions = New Panel()
        btnDelete = New Button()
        btnEdit = New Button()
        btnAdd = New Button()
        PanelSidebar.SuspendLayout()
        PanelLogo.SuspendLayout()
        PanelHeader.SuspendLayout()
        PanelMain.SuspendLayout()
        PanelDashboardOverview.SuspendLayout()
        PanelCardGrid.SuspendLayout()
        PanelCardStudents.SuspendLayout()
        PanelCardRooms.SuspendLayout()
        PanelCardIncidents.SuspendLayout()
        PanelActions.SuspendLayout()
        SuspendLayout()
        ' 
        ' PanelSidebar
        ' 
        PanelSidebar.BackColor = Color.FromArgb(15, 23, 42)
        PanelSidebar.Controls.Add(btnLogout)
        PanelSidebar.Controls.Add(btnCleanliness)
        PanelSidebar.Controls.Add(btnIncidents)
        PanelSidebar.Controls.Add(btnActivities)
        PanelSidebar.Controls.Add(btnFees)
        PanelSidebar.Controls.Add(btnAssignments)
        PanelSidebar.Controls.Add(btnApplications)
        PanelSidebar.Controls.Add(btnResidents)
        PanelSidebar.Controls.Add(btnRooms)
        PanelSidebar.Controls.Add(btnDashboard)
        PanelSidebar.Controls.Add(PanelLogo)
        PanelSidebar.Dock = DockStyle.Left
        PanelSidebar.Location = New Point(0, 0)
        PanelSidebar.Name = "PanelSidebar"
        PanelSidebar.Size = New Size(260, 700)
        PanelSidebar.TabIndex = 0
        ' 
        ' btnLogout
        ' 
        btnLogout.Dock = DockStyle.Bottom
        btnLogout.FlatAppearance.BorderSize = 0
        btnLogout.FlatStyle = FlatStyle.Flat
        btnLogout.Font = New Font("Segoe UI Semibold", 11F, FontStyle.Bold)
        btnLogout.ForeColor = Color.FromArgb(244, 63, 94)
        btnLogout.Location = New Point(0, 645)
        btnLogout.Name = "btnLogout"
        btnLogout.Padding = New Padding(20, 0, 0, 0)
        btnLogout.Size = New Size(260, 55)
        btnLogout.TabIndex = 10
        btnLogout.Text = "🚪  Logout"
        btnLogout.TextAlign = ContentAlignment.MiddleLeft
        btnLogout.UseVisualStyleBackColor = True
        ' 
        ' btnCleanliness
        ' 
        btnCleanliness.Dock = DockStyle.Top
        btnCleanliness.FlatAppearance.BorderSize = 0
        btnCleanliness.FlatStyle = FlatStyle.Flat
        btnCleanliness.Font = New Font("Segoe UI Semibold", 11F)
        btnCleanliness.ForeColor = Color.FromArgb(203, 213, 225)
        btnCleanliness.Location = New Point(0, 480)
        btnCleanliness.Name = "btnCleanliness"
        btnCleanliness.Padding = New Padding(20, 0, 0, 0)
        btnCleanliness.Size = New Size(260, 50)
        btnCleanliness.TabIndex = 9
        btnCleanliness.Text = "🧹  Cleanliness Logs"
        btnCleanliness.TextAlign = ContentAlignment.MiddleLeft
        btnCleanliness.UseVisualStyleBackColor = True
        ' 
        ' btnIncidents
        ' 
        btnIncidents.Dock = DockStyle.Top
        btnIncidents.FlatAppearance.BorderSize = 0
        btnIncidents.FlatStyle = FlatStyle.Flat
        btnIncidents.Font = New Font("Segoe UI Semibold", 11F)
        btnIncidents.ForeColor = Color.FromArgb(203, 213, 225)
        btnIncidents.Location = New Point(0, 430)
        btnIncidents.Name = "btnIncidents"
        btnIncidents.Padding = New Padding(20, 0, 0, 0)
        btnIncidents.Size = New Size(260, 50)
        btnIncidents.TabIndex = 8
        btnIncidents.Text = "⚠️  Manage Incidents"
        btnIncidents.TextAlign = ContentAlignment.MiddleLeft
        btnIncidents.UseVisualStyleBackColor = True
        ' 
        ' btnActivities
        ' 
        btnActivities.Dock = DockStyle.Top
        btnActivities.FlatAppearance.BorderSize = 0
        btnActivities.FlatStyle = FlatStyle.Flat
        btnActivities.Font = New Font("Segoe UI Semibold", 11F)
        btnActivities.ForeColor = Color.FromArgb(203, 213, 225)
        btnActivities.Location = New Point(0, 380)
        btnActivities.Name = "btnActivities"
        btnActivities.Padding = New Padding(20, 0, 0, 0)
        btnActivities.Size = New Size(260, 50)
        btnActivities.TabIndex = 7
        btnActivities.Text = "📅  Manage Activities"
        btnActivities.TextAlign = ContentAlignment.MiddleLeft
        btnActivities.UseVisualStyleBackColor = True
        ' 
        ' btnFees
        ' 
        btnFees.Dock = DockStyle.Top
        btnFees.FlatAppearance.BorderSize = 0
        btnFees.FlatStyle = FlatStyle.Flat
        btnFees.Font = New Font("Segoe UI Semibold", 11F)
        btnFees.ForeColor = Color.FromArgb(203, 213, 225)
        btnFees.Location = New Point(0, 330)
        btnFees.Name = "btnFees"
        btnFees.Padding = New Padding(20, 0, 0, 0)
        btnFees.Size = New Size(260, 50)
        btnFees.TabIndex = 6
        btnFees.Text = "💰  Manage Fees"
        btnFees.TextAlign = ContentAlignment.MiddleLeft
        btnFees.UseVisualStyleBackColor = True
        ' 
        ' btnAssignments
        ' 
        btnAssignments.Dock = DockStyle.Top
        btnAssignments.FlatAppearance.BorderSize = 0
        btnAssignments.FlatStyle = FlatStyle.Flat
        btnAssignments.Font = New Font("Segoe UI Semibold", 11F)
        btnAssignments.ForeColor = Color.FromArgb(203, 213, 225)
        btnAssignments.Location = New Point(0, 280)
        btnAssignments.Name = "btnAssignments"
        btnAssignments.Padding = New Padding(20, 0, 0, 0)
        btnAssignments.Size = New Size(260, 50)
        btnAssignments.TabIndex = 5
        btnAssignments.Text = "🔑  Room Assignments"
        btnAssignments.TextAlign = ContentAlignment.MiddleLeft
        btnAssignments.UseVisualStyleBackColor = True
        ' 
        ' btnApplications
        ' 
        btnApplications.Dock = DockStyle.Top
        btnApplications.FlatAppearance.BorderSize = 0
        btnApplications.FlatStyle = FlatStyle.Flat
        btnApplications.Font = New Font("Segoe UI Semibold", 11F)
        btnApplications.ForeColor = Color.FromArgb(203, 213, 225)
        btnApplications.Location = New Point(0, 230)
        btnApplications.Name = "btnApplications"
        btnApplications.Padding = New Padding(20, 0, 0, 0)
        btnApplications.Size = New Size(260, 50)
        btnApplications.TabIndex = 4
        btnApplications.Text = "📝  Manage Applications"
        btnApplications.TextAlign = ContentAlignment.MiddleLeft
        btnApplications.UseVisualStyleBackColor = True
        ' 
        ' btnResidents
        ' 
        btnResidents.Dock = DockStyle.Top
        btnResidents.FlatAppearance.BorderSize = 0
        btnResidents.FlatStyle = FlatStyle.Flat
        btnResidents.Font = New Font("Segoe UI Semibold", 11F)
        btnResidents.ForeColor = Color.FromArgb(203, 213, 225)
        btnResidents.Location = New Point(0, 180)
        btnResidents.Name = "btnResidents"
        btnResidents.Padding = New Padding(20, 0, 0, 0)
        btnResidents.Size = New Size(260, 50)
        btnResidents.TabIndex = 3
        btnResidents.Text = "👥  Manage Residents"
        btnResidents.TextAlign = ContentAlignment.MiddleLeft
        btnResidents.UseVisualStyleBackColor = True
        ' 
        ' btnRooms
        ' 
        btnRooms.Dock = DockStyle.Top
        btnRooms.FlatAppearance.BorderSize = 0
        btnRooms.FlatStyle = FlatStyle.Flat
        btnRooms.Font = New Font("Segoe UI Semibold", 11F)
        btnRooms.ForeColor = Color.FromArgb(203, 213, 225)
        btnRooms.Location = New Point(0, 130)
        btnRooms.Name = "btnRooms"
        btnRooms.Padding = New Padding(20, 0, 0, 0)
        btnRooms.Size = New Size(260, 50)
        btnRooms.TabIndex = 2
        btnRooms.Text = "🚪  Manage Rooms"
        btnRooms.TextAlign = ContentAlignment.MiddleLeft
        btnRooms.UseVisualStyleBackColor = True
        ' 
        ' btnDashboard
        ' 
        btnDashboard.Dock = DockStyle.Top
        btnDashboard.FlatAppearance.BorderSize = 0
        btnDashboard.FlatStyle = FlatStyle.Flat
        btnDashboard.Font = New Font("Segoe UI Semibold", 11F)
        btnDashboard.ForeColor = Color.FromArgb(203, 213, 225)
        btnDashboard.Location = New Point(0, 80)
        btnDashboard.Name = "btnDashboard"
        btnDashboard.Padding = New Padding(20, 0, 0, 0)
        btnDashboard.Size = New Size(260, 50)
        btnDashboard.TabIndex = 1
        btnDashboard.Text = "📊  Dashboard Overview"
        btnDashboard.TextAlign = ContentAlignment.MiddleLeft
        btnDashboard.UseVisualStyleBackColor = True
        ' 
        ' PanelLogo
        ' 
        PanelLogo.BackColor = Color.FromArgb(9, 15, 30)
        PanelLogo.Controls.Add(lblLogo)
        PanelLogo.Dock = DockStyle.Top
        PanelLogo.Location = New Point(0, 0)
        PanelLogo.Name = "PanelLogo"
        PanelLogo.Size = New Size(260, 80)
        PanelLogo.TabIndex = 0
        ' 
        ' lblLogo
        ' 
        lblLogo.Dock = DockStyle.Fill
        lblLogo.Font = New Font("Segoe UI Black", 14F, FontStyle.Bold)
        lblLogo.ForeColor = Color.White
        lblLogo.Location = New Point(0, 0)
        lblLogo.Name = "lblLogo"
        lblLogo.Size = New Size(260, 80)
        lblLogo.TabIndex = 0
        lblLogo.Text = "ADSSU ADMIN"
        lblLogo.TextAlign = ContentAlignment.MiddleCenter
        ' 
        ' PanelHeader
        ' 
        PanelHeader.BackColor = Color.White
        PanelHeader.Controls.Add(lblHeaderTitle)
        PanelHeader.Dock = DockStyle.Top
        PanelHeader.Location = New Point(260, 0)
        PanelHeader.Name = "PanelHeader"
        PanelHeader.Size = New Size(740, 80)
        PanelHeader.TabIndex = 1
        ' 
        ' lblHeaderTitle
        ' 
        lblHeaderTitle.AutoSize = True
        lblHeaderTitle.Font = New Font("Segoe UI Semibold", 18F, FontStyle.Bold)
        lblHeaderTitle.ForeColor = Color.FromArgb(15, 23, 42)
        lblHeaderTitle.Location = New Point(25, 24)
        lblHeaderTitle.Name = "lblHeaderTitle"
        lblHeaderTitle.Size = New Size(244, 32)
        lblHeaderTitle.TabIndex = 0
        lblHeaderTitle.Text = "Dashboard Overview"
        ' 
        ' PanelMain
        ' 
        PanelMain.BackColor = Color.FromArgb(241, 245, 249)
        PanelMain.Controls.Add(PanelDashboardOverview)
        PanelMain.Controls.Add(PanelActions)
        PanelMain.Dock = DockStyle.Fill
        PanelMain.Location = New Point(260, 80)
        PanelMain.Name = "PanelMain"
        PanelMain.Padding = New Padding(25)
        PanelMain.Size = New Size(740, 620)
        PanelMain.TabIndex = 2
        ' 
        ' PanelDashboardOverview
        ' 
        PanelDashboardOverview.Controls.Add(lblWelcome)
        PanelDashboardOverview.Controls.Add(PanelCardGrid)
        PanelDashboardOverview.Dock = DockStyle.Fill
        PanelDashboardOverview.Location = New Point(25, 85)
        PanelDashboardOverview.Name = "PanelDashboardOverview"
        PanelDashboardOverview.Size = New Size(690, 510)
        PanelDashboardOverview.TabIndex = 2
        ' 
        ' lblWelcome
        ' 
        lblWelcome.AutoSize = True
        lblWelcome.Font = New Font("Segoe UI Semibold", 13F)
        lblWelcome.ForeColor = Color.FromArgb(71, 85, 105)
        lblWelcome.Location = New Point(5, 5)
        lblWelcome.Name = "lblWelcome"
        lblWelcome.Size = New Size(393, 25)
        lblWelcome.TabIndex = 0
        lblWelcome.Text = "Welcome to the ADSSU OSAS Admin Dashboard"
        ' 
        ' PanelCardGrid
        ' 
        PanelCardGrid.Anchor = AnchorStyles.Top Or AnchorStyles.Left Or AnchorStyles.Right
        PanelCardGrid.ColumnCount = 3
        PanelCardGrid.ColumnStyles.Add(New ColumnStyle(SizeType.Percent, 33.33333F))
        PanelCardGrid.ColumnStyles.Add(New ColumnStyle(SizeType.Percent, 33.33333F))
        PanelCardGrid.ColumnStyles.Add(New ColumnStyle(SizeType.Percent, 33.33333F))
        PanelCardGrid.Controls.Add(PanelCardStudents, 0, 0)
        PanelCardGrid.Controls.Add(PanelCardRooms, 1, 0)
        PanelCardGrid.Controls.Add(PanelCardIncidents, 2, 0)
        PanelCardGrid.Location = New Point(0, 50)
        PanelCardGrid.Name = "PanelCardGrid"
        PanelCardGrid.RowCount = 1
        PanelCardGrid.RowStyles.Add(New RowStyle(SizeType.Percent, 100.0F))
        PanelCardGrid.Size = New Size(690, 160)
        PanelCardGrid.TabIndex = 1
        ' 
        ' PanelCardStudents
        ' 
        PanelCardStudents.BackColor = Color.White
        PanelCardStudents.BorderStyle = BorderStyle.None
        PanelCardStudents.Controls.Add(lblCardStudentsCount)
        PanelCardStudents.Controls.Add(lblCardStudentsTitle)
        PanelCardStudents.Dock = DockStyle.Fill
        PanelCardStudents.Location = New Point(10, 10)
        PanelCardStudents.Margin = New Padding(10)
        PanelCardStudents.Name = "PanelCardStudents"
        PanelCardStudents.Size = New Size(210, 140)
        PanelCardStudents.TabIndex = 0
        ' 
        ' lblCardStudentsCount
        ' 
        lblCardStudentsCount.AutoSize = True
        lblCardStudentsCount.Font = New Font("Segoe UI Black", 24F, FontStyle.Bold)
        lblCardStudentsCount.ForeColor = Color.FromArgb(79, 70, 229)
        lblCardStudentsCount.Location = New Point(15, 60)
        lblCardStudentsCount.Name = "lblCardStudentsCount"
        lblCardStudentsCount.Size = New Size(39, 45)
        lblCardStudentsCount.TabIndex = 1
        lblCardStudentsCount.Text = "0"
        ' 
        ' lblCardStudentsTitle
        ' 
        lblCardStudentsTitle.AutoSize = True
        lblCardStudentsTitle.Font = New Font("Segoe UI Semibold", 9.5F, FontStyle.Bold)
        lblCardStudentsTitle.ForeColor = Color.FromArgb(100, 116, 139)
        lblCardStudentsTitle.Location = New Point(15, 20)
        lblCardStudentsTitle.Name = "lblCardStudentsTitle"
        lblCardStudentsTitle.Size = New Size(140, 17)
        lblCardStudentsTitle.TabIndex = 0
        lblCardStudentsTitle.Text = "TOTAL RESIDENTS"
        ' 
        ' PanelCardRooms
        ' 
        PanelCardRooms.BackColor = Color.White
        PanelCardRooms.BorderStyle = BorderStyle.None
        PanelCardRooms.Controls.Add(lblCardRoomsCount)
        PanelCardRooms.Controls.Add(lblCardRoomsTitle)
        PanelCardRooms.Dock = DockStyle.Fill
        PanelCardRooms.Location = New Point(240, 10)
        PanelCardRooms.Margin = New Padding(10)
        PanelCardRooms.Name = "PanelCardRooms"
        PanelCardRooms.Size = New Size(210, 140)
        PanelCardRooms.TabIndex = 1
        ' 
        ' lblCardRoomsCount
        ' 
        lblCardRoomsCount.AutoSize = True
        lblCardRoomsCount.Font = New Font("Segoe UI Black", 24F, FontStyle.Bold)
        lblCardRoomsCount.ForeColor = Color.FromArgb(16, 185, 129)
        lblCardRoomsCount.Location = New Point(15, 60)
        lblCardRoomsCount.Name = "lblCardRoomsCount"
        lblCardRoomsCount.Size = New Size(39, 45)
        lblCardRoomsCount.TabIndex = 1
        lblCardRoomsCount.Text = "0"
        ' 
        ' lblCardRoomsTitle
        ' 
        lblCardRoomsTitle.AutoSize = True
        lblCardRoomsTitle.Font = New Font("Segoe UI Semibold", 9.5F, FontStyle.Bold)
        lblCardRoomsTitle.ForeColor = Color.FromArgb(100, 116, 139)
        lblCardRoomsTitle.Location = New Point(15, 20)
        lblCardRoomsTitle.Name = "lblCardRoomsTitle"
        lblCardRoomsTitle.Size = New Size(125, 17)
        lblCardRoomsTitle.TabIndex = 0
        lblCardRoomsTitle.Text = "TOTAL ROOMS"
        ' 
        ' PanelCardIncidents
        ' 
        PanelCardIncidents.BackColor = Color.White
        PanelCardIncidents.BorderStyle = BorderStyle.None
        PanelCardIncidents.Controls.Add(lblCardIncidentsCount)
        PanelCardIncidents.Controls.Add(lblCardIncidentsTitle)
        PanelCardIncidents.Dock = DockStyle.Fill
        PanelCardIncidents.Location = New Point(470, 10)
        PanelCardIncidents.Margin = New Padding(10)
        PanelCardIncidents.Name = "PanelCardIncidents"
        PanelCardIncidents.Size = New Size(210, 140)
        PanelCardIncidents.TabIndex = 2
        ' 
        ' lblCardIncidentsCount
        ' 
        lblCardIncidentsCount.AutoSize = True
        lblCardIncidentsCount.Font = New Font("Segoe UI Black", 24F, FontStyle.Bold)
        lblCardIncidentsCount.ForeColor = Color.FromArgb(239, 68, 68)
        lblCardIncidentsCount.Location = New Point(15, 60)
        lblCardIncidentsCount.Name = "lblCardIncidentsCount"
        lblCardIncidentsCount.Size = New Size(39, 45)
        lblCardIncidentsCount.TabIndex = 1
        lblCardIncidentsCount.Text = "0"
        ' 
        ' lblCardIncidentsTitle
        ' 
        lblCardIncidentsTitle.AutoSize = True
        lblCardIncidentsTitle.Font = New Font("Segoe UI Semibold", 9.5F, FontStyle.Bold)
        lblCardIncidentsTitle.ForeColor = Color.FromArgb(100, 116, 139)
        lblCardIncidentsTitle.Location = New Point(15, 20)
        lblCardIncidentsTitle.Name = "lblCardIncidentsTitle"
        lblCardIncidentsTitle.Size = New Size(140, 17)
        lblCardIncidentsTitle.TabIndex = 0
        lblCardIncidentsTitle.Text = "PENDING INCIDENTS"
        ' 
        ' PanelActions
        ' 
        PanelActions.BackColor = Color.Transparent
        PanelActions.Controls.Add(btnDelete)
        PanelActions.Controls.Add(btnEdit)
        PanelActions.Controls.Add(btnAdd)
        PanelActions.Dock = DockStyle.Top
        PanelActions.Location = New Point(25, 25)
        PanelActions.Name = "PanelActions"
        PanelActions.Size = New Size(690, 60)
        PanelActions.TabIndex = 1
        PanelActions.Visible = False
        ' 
        ' btnDelete
        ' 
        btnDelete.BackColor = Color.FromArgb(239, 68, 68)
        btnDelete.FlatAppearance.BorderSize = 0
        btnDelete.FlatStyle = FlatStyle.Flat
        btnDelete.Font = New Font("Segoe UI Semibold", 10F, FontStyle.Bold)
        btnDelete.ForeColor = Color.White
        btnDelete.Location = New Point(320, 5)
        btnDelete.Name = "btnDelete"
        btnDelete.Size = New Size(145, 42)
        btnDelete.TabIndex = 2
        btnDelete.Text = "❌  Delete Selected"
        btnDelete.UseVisualStyleBackColor = False
        ' 
        ' btnEdit
        ' 
        btnEdit.BackColor = Color.FromArgb(16, 185, 129)
        btnEdit.FlatAppearance.BorderSize = 0
        btnEdit.FlatStyle = FlatStyle.Flat
        btnEdit.Font = New Font("Segoe UI Semibold", 10F, FontStyle.Bold)
        btnEdit.ForeColor = Color.White
        btnEdit.Location = New Point(165, 5)
        btnEdit.Name = "btnEdit"
        btnEdit.Size = New Size(145, 42)
        btnEdit.TabIndex = 1
        btnEdit.Text = "✏️  Edit Selected"
        btnEdit.UseVisualStyleBackColor = False
        ' 
        ' btnAdd
        ' 
        btnAdd.BackColor = Color.FromArgb(79, 70, 229)
        btnAdd.FlatAppearance.BorderSize = 0
        btnAdd.FlatStyle = FlatStyle.Flat
        btnAdd.Font = New Font("Segoe UI Semibold", 10F, FontStyle.Bold)
        btnAdd.ForeColor = Color.White
        btnAdd.Location = New Point(5, 5)
        btnAdd.Name = "btnAdd"
        btnAdd.Size = New Size(150, 42)
        btnAdd.TabIndex = 0
        btnAdd.Text = "➕  Add Record"
        btnAdd.UseVisualStyleBackColor = False
        ' 
        ' Form2
        ' 
        AutoScaleDimensions = New SizeF(7F, 15F)
        AutoScaleMode = AutoScaleMode.Font
        ClientSize = New Size(1000, 700)
        Controls.Add(PanelMain)
        Controls.Add(PanelHeader)
        Controls.Add(PanelSidebar)
        Name = "Form2"
        StartPosition = FormStartPosition.CenterScreen
        Text = "ADSSU Dormitory - OSAS Admin Portal"
        WindowState = FormWindowState.Maximized
        PanelSidebar.ResumeLayout(False)
        PanelLogo.ResumeLayout(False)
        PanelHeader.ResumeLayout(False)
        PanelHeader.PerformLayout()
        PanelMain.ResumeLayout(False)
        PanelDashboardOverview.ResumeLayout(False)
        PanelDashboardOverview.PerformLayout()
        PanelCardGrid.ResumeLayout(False)
        PanelCardStudents.ResumeLayout(False)
        PanelCardStudents.PerformLayout()
        PanelCardRooms.ResumeLayout(False)
        PanelCardRooms.PerformLayout()
        PanelCardIncidents.ResumeLayout(False)
        PanelCardIncidents.PerformLayout()
        PanelActions.ResumeLayout(False)
        ResumeLayout(False)
    End Sub

    Friend WithEvents PanelSidebar As Panel
    Friend WithEvents PanelHeader As Panel
    Friend WithEvents PanelMain As Panel
    Friend WithEvents PanelLogo As Panel
    Friend WithEvents lblLogo As Label
    Friend WithEvents btnDashboard As Button
    Friend WithEvents btnRooms As Button
    Friend WithEvents btnResidents As Button
    Friend WithEvents btnApplications As Button
    Friend WithEvents btnAssignments As Button
    Friend WithEvents btnFees As Button
    Friend WithEvents btnActivities As Button
    Friend WithEvents btnIncidents As Button
    Friend WithEvents btnCleanliness As Button
    Friend WithEvents btnLogout As Button
    Friend WithEvents lblHeaderTitle As Label
    Friend WithEvents PanelDashboardOverview As Panel
    Friend WithEvents lblWelcome As Label
    Friend WithEvents PanelCardGrid As TableLayoutPanel
    Friend WithEvents PanelCardStudents As Panel
    Friend WithEvents lblCardStudentsCount As Label
    Friend WithEvents lblCardStudentsTitle As Label
    Friend WithEvents PanelCardRooms As Panel
    Friend WithEvents lblCardRoomsCount As Label
    Friend WithEvents lblCardRoomsTitle As Label
    Friend WithEvents PanelCardIncidents As Panel
    Friend WithEvents lblCardIncidentsCount As Label
    Friend WithEvents lblCardIncidentsTitle As Label
    Friend WithEvents PanelActions As Panel
    Friend WithEvents btnDelete As Button
    Friend WithEvents btnEdit As Button
    Friend WithEvents btnAdd As Button
End Class
