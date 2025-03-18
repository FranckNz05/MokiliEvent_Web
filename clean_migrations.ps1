$baseMigrations = @(
    "2014_10_12_000000_create_users_table.php",
    "2014_10_12_100000_create_password_reset_tokens_table.php",
    "2019_08_19_000000_create_failed_jobs_table.php",
    "2019_12_14_000001_create_personal_access_tokens_table.php",
    "2024_12_10_151016_create_mokilievent_platform_structure.php"
)

Get-ChildItem -Path "database/migrations" -Filter "*.php" | ForEach-Object {
    if ($baseMigrations -notcontains $_.Name) {
        Remove-Item $_.FullName -Force
        Write-Host "Deleted: $($_.Name)"
    }
}
