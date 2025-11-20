# 选择对象部件

Get-CimInstance -Class Win32_LogicalDisk | Select-Object -Property Name, FreeSpace


Get-CimInstance -Class Win32_LogicalDisk | Select-Object -Property Name, @{
    Label      = 'FreeSpace'
    Expression = { ($_.FreeSpace / 1GB).ToString('F2') }
}