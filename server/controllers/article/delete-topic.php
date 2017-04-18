<?php
use Respect\Validation\Validator as DataValidator;
DataValidator::with('CustomValidations', true);

/**
 * @api {post} /article/delete-topic Delete a topic.
 *
 * @apiName Delete topic
 *
 * @apiGroup article
 *
 * @apiDescription This path deletes a topic.
 *
 * @apiPermission Staff level 2
 *
 * @apiParam {number} topicId Id of the topic.
 *
 * @apiError {String} message
 *
 * @apiSuccess {Object} data
 *
 */

class DeleteTopicController extends Controller {
    const PATH = '/delete-topic';
    const METHOD = 'POST';

    public function validations() {
        return [
            'permission' => 'staff_2',
            'requestData' => [
                'topicId' => [
                    'validation' => DataValidator::dataStoreId('topic'),
                    'error' => ERRORS::INVALID_TOPIC
                ]
            ]
        ];
    }

    public function handler() {
        $topic = Topic::getDataStore(Controller::request('topicId'));
        
        Log::createLog('DELETE_TOPIC', $topic->name);

        $topic->delete();
        Response::respondSuccess();
    }
}