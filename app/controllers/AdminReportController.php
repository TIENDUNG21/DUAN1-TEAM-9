<?php
namespace App\controllers;

use App\models\ReportModel;

class AdminReportController {
    private $reportModel;

    public function __construct() {
        $this->reportModel = new ReportModel();
    }

    public function index() {
        $month = date('m');
        $year = date('Y');
        $revenueReport = $this->reportModel->getRevenueReport($month, $year);
        $userReport = $this->reportModel->getUserReport($month, $year);
        include __DIR__ . '/../../views/admin/reports/index.php';
    }
}