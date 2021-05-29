<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

class Google_Service_Document_GoogleCloudDocumentaiUiv1beta3EvaluationConfidenceLevelMetrics extends Google_Model
{
  public $confidenceLevel;
  protected $metricsType = 'Google_Service_Document_GoogleCloudDocumentaiUiv1beta3EvaluationMetrics';
  protected $metricsDataType = '';

  public function setConfidenceLevel($confidenceLevel)
  {
    $this->confidenceLevel = $confidenceLevel;
  }
  public function getConfidenceLevel()
  {
    return $this->confidenceLevel;
  }
  /**
   * @param Google_Service_Document_GoogleCloudDocumentaiUiv1beta3EvaluationMetrics
   */
  public function setMetrics(Google_Service_Document_GoogleCloudDocumentaiUiv1beta3EvaluationMetrics $metrics)
  {
    $this->metrics = $metrics;
  }
  /**
   * @return Google_Service_Document_GoogleCloudDocumentaiUiv1beta3EvaluationMetrics
   */
  public function getMetrics()
  {
    return $this->metrics;
  }
}
